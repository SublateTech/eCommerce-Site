<?php

/**
 * Collection of test cases for the TM::Apeform class. Requires PEAR::PHPUnit 1,
 * see http://pear.php.net/package/PHPUnit/
 */

require_once("Apeform.class.php");
require_once("PHPUnit.php");
require_once("PHPUnit/GUI/HTML.php");

class ApeformTest extends PHPUnit_TestCase
{
    var $f = null;

    function setUp()
    {
        $this->f = new Apeform();
        $this->f->templates = array(
            'form' =>
                "[FORM]{input}[/FORM]",
            'header' =>
                "[HEADER]{header}[/HEADER]",
            'input' =>
                "[INPUT]{label}{input}{help}[/INPUT]",
            'label' =>
                "[LABEL]{label}[/LABEL]",
            'error' =>
                "[ERROR]{error}[/ERROR]",
            'help' =>
                "[HELP]{help}[/HELP]");
        $this->PHP_SELF = $_SERVER['PHP_SELF'];
        $_SERVER['PHP_SELF'] = "[PHP_SELF]";
        $GLOBALS['HTTP_SERVER_VARS']['PHP_SELF'] = "[PHP_SELF]";
    }

    function tearDown()
    {
        $GLOBALS['HTTP_SERVER_VARS']['PHP_SELF'] = $this->PHP_SELF;
        $_SERVER['PHP_SELF'] = $this->PHP_SELF;
        $this->f = null;
    }

    function testApeform()
    {
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
        $this->assertEquals($expected, $this->f->toHtml());
        $this->assertEquals($expected, $this->f->toHtml());
    }

    function testApeformWithId()
    {
        $this->f->id = "X";
        $expected = "<form action=\"[PHP_SELF]#X\" id=\"X\" method=\"post\">[FORM]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
        $this->assertEquals($expected, $this->f->toHtml());
        $this->assertEquals($expected, $this->f->toHtml());
        $this->f->text();
        $expected = "<form action=\"[PHP_SELF]#X\" id=\"X\" method=\"post\">[FORM]" .
            "[INPUT]<input type=\"text\" name=\"Xelement0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"Xelement0i\" />[/INPUT]" .
            "[/FORM]</form>" .
            "<script type=\"text/javascript\"><!--\n" .
            "window.onload=function(){document.forms['X'].elements['Xelement0'].focus();}\n" .
            "//--></script>";
        $this->assertEquals($expected, $this->f->toHtml(true));
        $this->assertEquals($expected, $this->f->toHtml(true));
        $this->f->text("LABEL", "HELP", "VALUE", 71, 29);
        $expected = "<form action=\"[PHP_SELF]#X\" id=\"X\" method=\"post\">[FORM]" .
            "[INPUT]<input type=\"text\" name=\"Xelement0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"Xelement0i\" />[/INPUT]" .
            "[INPUT]<label for=\"Xelement1i\">[LABEL]LABEL[/LABEL]</label><input type=\"text\" name=\"Xelement1\" value=\"VALUE\" maxlength=\"71\" size=\"29\" id=\"Xelement1i\" title=\"HELP\" />[HELP]HELP[/HELP][/INPUT]" .
            "[/FORM]</form>" .
            "<script type=\"text/javascript\"><!--\n" .
            "window.onload=function(){document.forms['X'].elements['Xelement0'].focus();}\n" .
            "//--></script>";
        $this->assertEquals($expected, $this->f->toHtml(true));
    }

    function testTemplates()
    {
        $this->f->templates['input'] = "[INPUT]{help}{label}{input}[/INPUT]";
        $this->f->_isSubmitted = true;
        $this->f->text("<u>a</u>x", "h", "v");
        $this->f->error("xa");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\">[ERROR]x<u>a</u>[/ERROR]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
        $this->f->_rows[0]['error'] = "";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\">[ERROR]<u>a</u>x[/ERROR]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
        $this->f->_rows[0]['label'] = "";
        $this->f->_rows[0]['error'] = "x<u>a</u>";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\">[ERROR]x<u>a</u>[/ERROR]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
    }

    function testTemplatesWithErrorTag()
    {
        $this->f->templates['input'] = "[INPUT]{help}{label}{input}{error}[/INPUT]";
        $this->f->_isSubmitted = true;
        $this->f->text("<u>a</u>x", "h", "v");
        $this->f->error("xa");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\">[LABEL]<u>a</u>x[/LABEL]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[ERROR]xa[/ERROR]" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
        $this->f->_rows[0]['error'] = "";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\">[LABEL]<u>a</u>x[/LABEL]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
        $this->f->_rows[0]['label'] = "";
        $this->f->_rows[0]['error'] = "x<u>a</u>";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "[HELP]h[/HELP]" .
            "<label accesskey=\"a\" for=\"element0i\"></label>" .
            "<input type=\"text\" name=\"element0\" value=\"v\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"h\" />" .
            "[ERROR]x<u>a</u>[/ERROR]" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
    }

    function testTemplatesWithoutSubtemplates()
    {
        unset($this->f->templates['label']);
        unset($this->f->templates['error']);
        unset($this->f->templates['help']);
        $this->f->_isSubmitted = true;
        $this->f->text("<u>a</u>x");
        $this->f->error("xa");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "<label accesskey=\"a\" for=\"element0i\">x<u>a</u></label>" .
            "<input type=\"text\" name=\"element0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"element0i\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));

        $this->f->templates['input'] = "[INPUT]{label}{error}{input}{help}[/INPUT]";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "<label accesskey=\"a\" for=\"element0i\"><u>a</u>x</label>" .
            "xa" .
            "<input type=\"text\" name=\"element0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"element0i\" />" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
    }

    function testUnit()
    {
        $this->f->text("L", "H\tU");
        $this->f->staticText("", "\tU", "V");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]" .
            "<label for=\"element0i\">[LABEL]L[/LABEL]</label>" .
            "<input type=\"text\" name=\"element0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"element0i\" title=\"H\" />" .
            " U" .
            "[HELP]H[/HELP]" .
            "[/INPUT]" .
            "[INPUT]" .
            "V<input type=\"hidden\" name=\"element1\" value=\"V\" />" .
            " U" .
            "[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml(false));
    }

    function testHeader()
    {
        $this->f->header("bla");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[HEADER]bla[/HEADER]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
        $this->f->header("2nd");
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[HEADER]bla[/HEADER]" .
            "[HEADER]2nd[/HEADER]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
    }

    function testStaticText()
    {
        $this->f->staticText("Blabel", "Bhelp", "Bval");
        $this->f->staticText("Clabel", "Chelp");
        $this->f->staticText("Dlabel");
        $this->f->staticText();
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT][LABEL]Blabel[/LABEL]Bval<input type=\"hidden\" name=\"element0\" value=\"Bval\" />[HELP]Bhelp[/HELP][/INPUT]" .
            "[INPUT][LABEL]Clabel[/LABEL]<input type=\"hidden\" name=\"element1\" value=\"\" />[HELP]Chelp[/HELP][/INPUT]" .
            "[INPUT][LABEL]Dlabel[/LABEL]<input type=\"hidden\" name=\"element2\" value=\"\" />[/INPUT]" .
            "[INPUT]<input type=\"hidden\" name=\"element3\" value=\"\" />[/INPUT]" .
            "[/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
    }

    function testText()
    {
        $this->f->text();
        $this->assertEquals("text", $this->f->_rows[0]['type']);
        $this->assertEquals("", $this->f->_rows[0]['value']);
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]<input type=\"text\" name=\"element0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"element0i\" />[/INPUT]" .
            "[/FORM]</form>" .
            "<script type=\"text/javascript\"><!--\n" .
            "window.onload=function(){document.forms['form'].elements['element0'].focus();}\n" .
            "//--></script>";
        $this->assertEquals($expected, $this->f->toHtml());
        $this->assertEquals($expected, $this->f->toHtml());
        $var = &$this->f->text("LABEL", "HELP", "DEFAULTVALUE", 71, 29);
        $this->assertEquals("DEFAULTVALUE", $var);
        $var = "VALUE";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">[FORM]" .
            "[INPUT]<input type=\"text\" name=\"element0\" value=\"\" maxlength=\"255\" size=\"40\" id=\"element0i\" />[/INPUT]" .
            "[INPUT]<label for=\"element1i\">[LABEL]LABEL[/LABEL]</label><input type=\"text\" name=\"element1\" value=\"VALUE\" maxlength=\"71\" size=\"29\" id=\"element1i\" title=\"HELP\" />[HELP]HELP[/HELP][/INPUT]" .
            "[/FORM]</form>" .
            "<script type=\"text/javascript\"><!--\n" .
            "window.onload=function(){document.forms['form'].elements['element0'].focus();}\n" .
            "//--></script>";
        $this->assertEquals($expected, $this->f->toHtml());
    }

    function testPassword()
    {
        // Fake the submitted state.
        $this->f->_isSubmitted = true;
        $this->assertEquals("", $this->f->password());
        $this->assertEquals("V", $this->f->password("L", "H", "V"));
        $val = &$this->f->password("L", "H", "V");
        $this->f->error();
        $this->assertTrue($this->f->_hasErrors);
        $this->assertEquals("", $val);
    }

    function testHidden()
    {
        $this->assertEquals("", $this->f->hidden());
        $this->assertEquals("element0", $this->f->getName());
        $this->assertEquals("SPEC", $this->f->hidden("SPEC"));
        $this->assertEquals("element1", $this->f->getName());
        $this->assertEquals("SPECVAL", $this->f->hidden("SPECVAL", "SPECNAME"));
        $this->assertEquals("SPECNAME", $this->f->getName());
        $this->f->id = "UNIQue";
        $this->assertEquals("A", $this->f->hidden("A", "B"));
        $this->assertEquals("B", $this->f->getName());
        $this->assertEquals("C", $this->f->hidden("C"));
        $this->assertEquals("hidden", $this->f->_rows[4]['type']);
        $this->assertEquals("UNIQueelement4", $this->f->_rows[4]['name']);
        $this->assertEquals("C", $this->f->_rows[4]['value']);
        $this->assertEquals("UNIQueelement4", $this->f->getName());

        $this->f->_rows = array();
        $this->f->id = "form";
        $val = &$this->f->hidden("DEFVAL", "NAME");
        $val = "VAL";
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">" .
            "<input type=\"hidden\" name=\"NAME\" value=\"VAL\" />" .
            "[FORM][/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
        $this->f->hidden();
        $expected = "<form action=\"[PHP_SELF]#form\" id=\"form\" method=\"post\">" .
            "<input type=\"hidden\" name=\"NAME\" value=\"VAL\" />" .
            "<input type=\"hidden\" name=\"element1\" value=\"\" />" .
            "[FORM][/FORM]</form>";
        $this->assertEquals($expected, $this->f->toHtml());
    }

    function testCheckbox()
    {
        $this->assertEquals("", $this->f->checkbox("lABEl"));
        $this->assertEquals("OP", $this->f->checkbox("L", "", "OP", "OP"));
        $this->assertEquals("", $this->f->checkbox("L", "", "OP", ""));
        $this->assertEquals("", $this->f->checkbox("L", "", "OP"));
        $val = $this->f->checkbox("L", "", "V1|V2", "V2");
        $this->assertEquals(array('V2' => "V2"), $val);
        $val = $this->f->checkbox("L", "", array("E", "F", "G"), "F");
        $this->assertEquals(array('F' => "F"), $val);
        $val = $this->f->checkbox("L", "", "V1|V2");
        $this->assertEquals(array(), $val);
    }

    function testRadio()
    {
        $val = $this->f->radio("Radio", "", "Value 1|Value 2", "Value 2");
        $this->assertEquals("Value 2", $val);
        $val = $this->f->radio("Radio", "", "A|B");
        $this->assertEquals("", $val);
        $val = $this->f->radio("Radio", "", array(5 => "G", 6 => "H"), "H");
        $this->assertEquals(6, $val);
    }

    function testSelect()
    {
        $val = $this->f->select("LABEL", "HELP", "OPTION(S)");
        $this->assertEquals("", $val);
        $val = $this->f->select("Sel", "", array(1 => "A", 2 => "B"), 2);
        $this->assertEquals(2, $val);
        $val = $this->f->select("Sel", "", "A|B", "B");
        $this->assertEquals("B", $val);
        $val = $this->f->select("Sel", "", array('A' => "B", 'C' => "D"), "D");
        $this->assertEquals("C", $val);
        $val = $this->f->select("Sel", "", array("U", "V"), 1);
        $this->assertEquals(1, $val);
    }

    function testSubmit()
    {
        $this->assertFalse($this->f->submit());
        $this->assertFalse($this->f->submit("Value", "Help"));
        $this->assertFalse($this->f->submit("A|B|C"));
    }

    function testGetName()
    {
        $this->assertFalse($this->f->getName());
        $this->f->text();
        $this->assertEquals("element0", $this->f->getName());
        $this->f->id = "ID";
        $this->f->text();
        $this->assertEquals("IDelement1", $this->f->getName());
        $this->f->id = "form";
        $this->f->select("LABEL", "HELP", "A|B");
        $this->assertEquals("element2", $this->f->getName());
        $this->f->id = "foRm";
        $this->f->checkbox("");
        $this->assertEquals("foRmelement3", $this->f->getName());
    }

    function testMagicQuotes()
    {
        $this->assertEquals(get_magic_quotes_gpc(), $this->f->magicQuotes);
        $this->f->magicQuotes = true;
        $this->assertEquals("VALUE\'", $this->f->text("", "", "VALUE'"));
        $this->f->magicQuotes = false;
        $this->assertEquals("VALUE'", $this->f->text("", "", "VALUE'"));
    }

    function testIsValid()
    {
        $this->f->text();
        $this->assertFalse($this->f->isValid());
        // Fake the submitted state.
        $this->f->_isSubmitted = true;
        $this->assertTrue($this->f->isValid());
        $this->f->error();
        $this->assertFalse($this->f->isValid());
    }
}

$suite = new PHPUnit_TestSuite("ApeformTest");
//- $result = PHPUnit::run($suite);
//- echo $result->toHTML();
$gui = new PHPUnit_GUI_HTML($suite);
$gui->show();

?>