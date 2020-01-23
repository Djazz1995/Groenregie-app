<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Delivery\Resource;

use Contentful\Core\Api\Link;
use Contentful\Core\Exception\NotFoundException;
use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\ContentType\Field;

class Entry extends LocalizedResource implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * Returns the space this entry belongs to.
     *
     * @return Space
     */
    public function getSpace()
    {
        return $this->sys->getSpace();
    }

    /**
     * Returns the environment this entry belongs to.
     *
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->sys->getEnvironment();
    }

    /**
     * @return ContentType|null
     */
    public function getContentType()
    {
        return $this->sys->getContentType();
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (0 === \mb_strpos($name, 'has')) {
            $field = $this->sys->getContentType()->getField($name, true);

            // Only works if the "has" is "magic", i.e.
            // the field is not actually called hasSomething.
            if (!$field) {
                return $this->has(\mb_substr($name, 3));
            }
        }

        // Some templating languages might end up trying to access a field
        // using a method-like syntax "$entry->field()".
        // Even though it's not the suggested approach, we allow that syntax
        // for maximum compatibility purposes.
        if (0 === \mb_strpos($name, 'get')) {
            $name = \mb_substr($name, 3);
        }

        $locale = $this->getLocaleFromInput(isset($arguments[0]) ? $arguments[0] : null);

        $result = null;
        try {
            $result = $this->get($name, $locale);
        } catch (\Exception $exception) {
            \trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
        }

        // This is an ugly hack to trick the coverage reporter;
        // we could be returning this in the try/catch without creating a variable,
        // but for some reason the coverage reporter will detect a non-covered
        // closing bracket at the end of the method...
        return $result;
    }

    /**
     * Shortcut for accessing fields using $entry->fieldName.
     * It will use the locale currently defined.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($name)
    {
        return $this->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($name, $value)
    {
        throw new \LogicException('Entry class does not support setting fields.');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($name)
    {
        throw new \LogicException('Entry class does not support unsetting fields.');
    }

    /**
     * Checks whether the current entry has a field with a certain ID.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        $field = $this->sys->getContentType()->getField($name, true);

        return $field ? \array_key_exists($field->getId(), $this->fields) : false;
    }

    /**
     * Returns a the value of a field using the given locale.
     * It will also resolve links. If you want to access the ID of a link
     * or of an array of links, simply append "Id" to the end of the
     * $name parameter.
     *
     * ```
     * $author = $entry->get('author');
     * $id = $entry->get('authorId');
     * ```
     *
     * @param string      $name
     * @param string|null $locale
     * @param bool        $resolveLinks If set to false, links and array of links will not be resolved
     *
     * @return mixed
     */
    public function get($name, $locale = null, $resolveLinks = true)
    {
        $field = $this->sys->getContentType()->getField($name, true);
        if ($field) {
            $result = $this->getUnresolvedField($field, $locale);

            return $resolveLinks
                ? $this->resolveFieldLinks($result, $locale)
                : $result;
        }

        // If no clean match was found using the provided field name,
        // let's attempt to see if we're fetching an ID of a link or array of links.
        $value = $this->getFieldWithId($name, $locale);
        if (null !== $value) {
            return $value;
        }

        throw new \InvalidArgumentException(\sprintf(
            'Trying to access non existent field "%s" on an entry with content type "%s" ("%s").',
            $name,
            $this->sys->getContentType()->getName(),
            $this->sys->getContentType()->getSystemProperties()->getId()
        ));
    }

    /**
     * Attempts to fetch a value given the current configuration.
     * It will return the raw field value,
     * without applying any transformation to it.
     *
     * @param Field       $field
     * @param string|null $locale
     *
     * @return mixed
     */
    private function getUnresolvedField(Field $field, $locale = null)
    {
        // The field is not currently available on this resource,
        // but it exists in the content type, so we return an appropriate
        // default value.
        if (!isset($this->fields[$field->getId()])) {
            return 'Array' === $field->getType() ? [] : null;
        }

        $value = $this->fields[$field->getId()];

        // This also checks two things:
        // * the compatibility of the given locale with the one present in sys.locale
        // * the existence of the given locale among those available in the environment
        // If we're trying to access locale X and the entry was built with locale Y,
        // or the environment does not support such locale, an exception will be thrown.
        // To allow accessing multiple locales on a single entry, fetching it
        // with locale=* is required.
        $locale = $this->getLocaleFromInput($locale);

        if (\array_key_exists($locale, $value)) {
            return $value[$locale];
        }

        // If a field is not localized, it means that there are no values besides
        // $value[$defaultLocale], so because that check has already happened, we know
        // we're trying to access an invalid locale which is not correctly set.
        if (!$field->isLocalized()) {
            throw new \InvalidArgumentException(\sprintf(
                'Trying to access the non-localized field "%s" on content type "%s" using the non-default locale "%s".',
                $field->getName(),
                $this->sys->getContentType()->getName(),
                $locale
            ));
        }

        // If we reach this point, it means:
        // * the field is localized
        // * we're trying to get a non-default locale
        // * the entry was not built using a specific locale (i.e. all locales for a field are available)
        // Therefore, we can inspect the fallback chain for a suitable locale.
        $locale = $this->walkFallbackChain($value, $locale, $this->sys->getEnvironment());

        if ($locale) {
            return $value[$locale];
        }

        return 'Array' === $field->getType() ? [] : null;
    }

    /**
     * Given a field value, this method will resolve links
     * if it's a Link object or an array of links.
     *
     * @param mixed       $field
     * @param string|null $locale
     *
     * @return mixed
     */
    private function resolveFieldLinks($field, $locale)
    {
        if ($field instanceof Link) {
            return $this->client->resolveLink($field, $locale);
        }

        if (\is_array($field) && isset($field[0]) && $field[0] instanceof Link) {
            return \array_filter(\array_map(function (Link $value) use ($locale) {
                try {
                    return $this->client->resolveLink($value, $locale);
                } catch (NotFoundException $exception) {
                    return null;
                }
            }, $field));
        }

        return $field;
    }

    /**
     * Checks whether the given $name parameter corresponds to an attempt
     * of fetching the ID of a link (or array of links).
     *
     * @param string      $name
     * @param string|null $locale
     *
     * @return null|string|string[] Returns null if $name is not a valid field ID string
     */
    private function getFieldWithId($name, $locale)
    {
        if ('Id' !== \mb_substr($name, -2)) {
            return null;
        }

        $field = $this->sys->getContentType()->getField(\mb_substr($name, 0, -2), true);
        if (!$field) {
            return null;
        }

        if ('Link' !== $field->getType() && ('Array' !== $field->getType() || 'Link' !== $field->getItemsType())) {
            return null;
        }

        $value = $this->getUnresolvedField($field, $locale);
        if ($value instanceof Link) {
            return $value->getId();
        }

        return \array_map(function (Link $link) {
            return $link->getId();
        }, $value);
    }

    /**
     * Gets all entries that contain links to the current one.
     * You can provide a Query object in order to set parameters
     * such as locale, include, and sorting.
     *
     * @param Query|null $query
     *
     * @return ResourceArray
     */
    public function getReferences(Query $query = null)
    {
        $query = $query ?: new Query();
        $query->linksToEntry($this->getId());

        return $this->client->getEntries($query);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $locale = $this->sys->getLocale();

        $fields = new \stdClass();
        foreach ($this->fields as $name => $value) {
            $fields->$name = $locale ? $value[$locale] : $value;
        }

        return [
            'sys' => $this->sys,
            'fields' => $fields,
        ];
    }
}
