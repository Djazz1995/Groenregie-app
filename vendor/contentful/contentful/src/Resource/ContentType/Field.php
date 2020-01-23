<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Delivery\Resource\ContentType;

/**
 * A Field describes one field of a ContentType.
 * This includes essential information for the display of the field's value.
 */
class Field implements \JsonSerializable
{
    /**
     * ID of the Field.
     *
     * @var string
     */
    protected $id;

    /**
     * Name of the Field.
     *
     * @var string
     */
    protected $name;

    /**
     * Type of the Field.
     *
     * Valid values are:
     * - Symbol
     * - Text
     * - Integer
     * - Number
     * - Date
     * - Boolean
     * - Link
     * - Array
     * - Object
     *
     * @var string
     */
    protected $type;

    /**
     * Type of the linked resource.
     *
     * Valid values are:
     * - Asset
     * - Entry
     *
     * @var string|null
     */
    protected $linkType;

    /**
     * (Array type only) Type for items.
     *
     * @var string|null
     */
    protected $itemsType;

    /**
     * (Array of links only) Type of links.
     *
     * Valid values are:
     * - Asset
     * - Entry
     *
     * @var string|null
     */
    protected $itemsLinkType;

    /**
     * Describes whether the Field is mandatory.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Describes whether the Field is localized.
     *
     * @var bool
     */
    protected $localized = false;

    /**
     * Describes whether the Field is disabled.
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * Regular field construction should happen through the field mapper.
     * This here is a special exception needed for when building fields on type
     * "Unknown", in the edge case of cache being out of sync with the API.
     *
     * @param string $id
     * @param string $name
     * @param string $type
     */
    public function __construct($id, $name, $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Returns the ID of the content type.
     *
     * This is the internal identifier of the content type and is unique in the space.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the name of the content type.
     *
     * This is a human friendly name shown to the user.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the type of the field.
     *
     * Possible values are:
     * - Symbol
     * - Text
     * - Integer
     * - Number
     * - Date
     * - Boolean
     * - Link
     * - Array
     * - Object
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * If the field is a link, this will return the type of the linked resource.
     *
     * Possible values are:
     * - Asset
     * - Entry
     *
     * @return string|null
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * Returns true if this field is required.
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Returns true if the field contains locale dependent content.
     *
     * @return bool
     */
    public function isLocalized()
    {
        return $this->localized;
    }

    /**
     * True if the field is disabled.
     *
     * Disabled fields are part of the API responses but not accessible trough the PHP SDK.
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * If the field is an array, this returns the type of its items.
     *
     * Possible values are:
     * - Symbol
     * - Text
     * - Integer
     * - Number
     * - Date
     * - Boolean
     * - Link
     * - Object
     *
     * @return string|null
     */
    public function getItemsType()
    {
        return $this->itemsType;
    }

    /**
     * If the field is an array, and it's items are links, this returns the type of the linked resources.
     *
     * Possible values are:
     * - Asset
     * - Entry
     *
     * @return string|null
     */
    public function getItemsLinkType()
    {
        return $this->itemsLinkType;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $field = [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
            'localized' => $this->localized,
        ];

        if ($this->disabled) {
            $field['disabled'] = true;
        }

        if (null !== $this->linkType) {
            $field['linkType'] = $this->linkType;
        }

        if ('Array' === $this->type) {
            $field['items'] = [
                'type' => $this->itemsType,
            ];
            if ('Link' === $this->itemsType) {
                $field['items']['linkType'] = $this->itemsLinkType;
            }
        }

        return $field;
    }
}
