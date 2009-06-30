<?php
/**
* PEAR OpenDocument package
* 
* PHP version 5
*
* LICENSE: This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
* 
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
* 
* @category File_Formats
* @package  OpenDocument
* @author   Alexander Pak <irokez@gmail.com>
* @license  http://www.gnu.org/copyleft/lesser.html  Lesser General Public License 2.1
* @version  CVS: $Id$
* @link     http://pear.php.net/package/OpenDocument
* @since    File available since Release 0.1.0
*/

require_once 'OpenDocument/StyledElement.php';

/**
* Span element
*
* @category File_Formats
* @package  OpenDocument
* @author   Alexander Pak <irokez@gmail.com>
* @license  http://www.gnu.org/copyleft/lesser.html  Lesser General Public License 2.1
* @link     http://pear.php.net/package/OpenDocument
*/
class OpenDocument_Element_Span extends OpenDocument_StyledElement
{
    /**
     * Node namespace
     */
    const nodeNS = OpenDocument::NS_TEXT;

    /**
     * Node amespace
     */
    const nodePrefix = 'text';
    
    /**
     * Node name
     */
    const nodeName = 'span';
    
    /**
     * Element style name prefix
     */
    const styleNamePrefix = 'T';

    /**
     * Style family to use
     *
     * @var string
     */
    const styleFamily = 'text';

    /**
     * Create element instance
     *
     * @param mixed $object  Document or Element to append span to
     * @param mixed $content Span contents
     *
     * @return OpenDocument_Element_Span
     *
     * @throws OpenDocument_Exception
     */
    public static function instance($object, $content)
    {
        if ($object instanceof OpenDocument_Document) {
            $document = $object;
            $node = $object->cursor;
        } else if ($object instanceof OpenDocument_Element) {
            $document = $object->getDocument();
            $node = $object->getNode();
        } else {
            throw new OpenDocument_Exception(
                OpenDocument_Exception::ELEM_OR_DOC_EXPECTED
            );
        }
        
        $element = new OpenDocument_Element_Span(
            $node->ownerDocument->createElementNS(
                self::nodeNS, self::nodeName
            ),
            $document
        );
        $node->appendChild($element->node);

        if (is_scalar($content)) {
            $element->createTextElement($content);
        }

        return $element;
    }

    /**
     * Generate new style name
     *
     * @return string Name of new style
     */
    public function generateStyleName()
    {
        self::$styleNameMaxNumber++;
        return self::styleNamePrefix . self::$styleNameMaxNumber;
    }

    /************** Elements ****************/
    
    /**
     * Create a text element
     *
     * @param string $text Text content
     *
     * @return OpenDocument_Element_Text
     */
    public function createTextElement($text)
    {
        return OpenDocument_Element_Text::instance($this, $text);
    }
}
?>