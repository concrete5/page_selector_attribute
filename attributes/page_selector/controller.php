<?php
namespace Concrete\Package\PageSelectorAttribute\Attribute\PageSelector;

use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Core\Entity\Attribute\Key\Type\NumberType;
use Concrete\Core\Entity\Attribute\Value\Value\NumberValue;
use Concrete\Core\Form\Service\Widget\PageSelector;
use Concrete\Core\Page\Page;
use Concrete\Package\PageSelectorAttribute\Entity\Attribute\Value\Value\PageValue;

class Controller extends \Concrete\Attribute\Number\Controller
{

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('link');
    }

    public function form()
    {
        $value = null;
        if (is_object($this->attributeValue)) {
            $value = $this->getAttributeValue()->getValue();
        }
        if (!$value) {
            if ($this->request->query->has($this->attributeKey->getAttributeKeyHandle())) {
                $value = $this->createAttributeValue(intval($this->request->query->get($this->attributeKey->getAttributeKeyHandle())));
            }
        }
        $this->set('value', $value);
    }

    public function getDisplayValue()
    {
        $cID = $this->getAttributeValue()->getValue();
        $page = Page::getByID($cID, 'ACTIVE');
        if (is_object($page) && !$page->isError()) {
            return t('<a href="%s">%s</a>', $page->getCollectionLink(), $page->getCollectionName());
        }
    }

    public function getPlainTextValue()
    {
        $cID = $this->getAttributeValue()->getValue();
        $page = Page::getByID($cID, 'ACTIVE');
        if (is_object($page) && !$page->isError()) {
            return $page->getCollectionLink();
        }
    }

	public function createAttributeValue($value)
	{
		$av = new NumberValue();
        if ($value instanceof Page) {
            $value = $value->getCollectionID();
        }
		$av->setValue($value);
		return $av;
	}

    public function importValue(\SimpleXMLElement $akv)
    {
        if (isset($akv->value)) {
            $c = Page::getByPath((string) $akv->value);
            if (is_object($c) && !$c->isError()) {
                return $c->getCollectionID();
            }
        }
    }

    public function exportValue(\SimpleXMLElement $akn)
    {
        if (is_object($this->attributeValue)) {
            $cID = $this->getAttributeValue()->getValue();
            $page = Page::getByID($cID, 'ACTIVE');
            $avn = $akn->addChild('value', $page->getCollectionPath());
        }
    }



}