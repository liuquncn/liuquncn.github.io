<? require( "functions.php" ); displayHeader( "Using HTML" ); ?>
<p align="center">[ <a href="javascript:history.back();">Back</a> ]</p>
<div align="center">
  <center>
  <table border="0" cellpadding="0" width="443" height="427" cellspacing="0">
    <tr>
      <td width="443" height="28" colspan="2" bgcolor="#FFCC00">
        <p align="center"><b><font  size=3>USING HTML</font></b></td>
    </tr>
    <tr>
      <td width="443" height="107" colspan="2">
        <table border="0" cellpadding="0" width="100%" cellspacing="4">
          <tr>
            <td width="100%"><small>Following syntax allows your to
        customize your message with styles.&nbsp; It's basically the variation
        of HTML codes.</small>
        <p><small><b>Note:<br>
        </b>&gt; Syntax is in red.<br>
        &gt; Incorrect code will not lead to any errors<br>
        &gt; <b> <u> Use one style at a time.</u></b> That means you can do it like this <font color=#FF0000>[b][i]</font>Hello!<font color=#FF0000>[/i][/b]</font>,
        you have to do it either <font color=#FF0000>[b]</font>Hello!<font color=#FF0000>[/b]</font> or <font color=#FF0000>[i]</font>Hello!<font color=#FF0000>[/i]</font></small></p>
            </td>
          </tr>
        </table>
        <hr size="1" color="#808080" width="80%">
      </td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2"><b><font color="#000000">&nbsp;Bold</font></b></td>
    </tr>
    <tr>
      <td width="79" height="22">&nbsp;Syntax:</td>
      <td width="364" height="22"><font color="#FF0000">[b]</font>Text here<font color="#FF0000">[/b]</font></td>
    </tr>
    <tr>
      <td width="79" height="22">&nbsp;Example:</td>
      <td width="364" height="22"><b>This is bold text</b></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2">&nbsp;<b><font color="#000000">Italic</font></b></td>
    </tr>
    <tr>
      <td width="81" height="22">&nbsp;Syntax:</td>
      <td width="362" height="22"><font color="#FF0000">[i]</font>Text here<font color="#FF0000">[/i]</font></td>
    </tr>
    <tr>
      <td width="81" height="22">&nbsp;Example:</td>
      <td width="362" height="22"><i>This is italic text</i></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2">&nbsp;<b><font color="#000000">Underline</font></b></td>
    </tr>
    <tr>
      <td width="83" height="22">&nbsp;Syntax:</td>
      <td width="360" height="22"><font color="#FF0000">[u]</font>Text here<font color="#FF0000">[/u]</font></td>
    </tr>
    <tr>
      <td width="83" height="22">&nbsp;Example:</td>
      <td width="360" height="22"><u>This is underline text</u></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2">&nbsp;<b><font color="#000000">URL</font></b></td>
    </tr>
    <tr>
      <td width="85" height="22">&nbsp;Syntax:</td>
      <td width="358" height="22"><font color="#FF0000">[url=URL here]</font>text here<font color="#FF0000">[/url]</font></td>
    </tr>
    <tr>
      <td width="85" height="22">&nbsp;Example:</td>
      <td width="358" height="22"><a href="http://">This is hyperlink</a></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2"><font color="#000000">&nbsp;<b>E-mail</b></font></td>
    </tr>
    <tr>
      <td width="86" height="22">&nbsp;Syntax:</td>
      <td width="357" height="22"><font color="#FF0000">[email]</font>E-mail
        address<font color="#FF0000">[/email]</font></td>
    </tr>
    <tr>
      <td width="86" height="22">&nbsp;Example:</td>
      <td width="357" height="22"><a href="mailto:">This is e-mail link</a></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2"><font color="#000000">&nbsp;<b>Image</b></font></td>
    </tr>
    <tr>
      <td width="87" height="22">&nbsp;Syntax:</td>
      <td width="356" height="22"><font color="#FF0000">[img]</font>Image link
        here<font color="#FF0000">[/img]</font></td>
    </tr>
    <tr>
      <td width="87" height="22">&nbsp;Example:</td>
      <td width="356" height="22">N/A</td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2"><font color="#000000">&nbsp;<b>Font
        Color</b></font></td>
    </tr>
    <tr>
      <td width="88" height="22">&nbsp;Syntax:</td>
      <td width="355" height="22"><font color="#FF0000">[color=green]</font>Text
        here<font color="#FF0000">[/color]</font></td>
    </tr>
    <tr>
      <td width="88" height="22">&nbsp;Example:</td>
      <td width="355" height="22"><font color="#008000">It's green color</font></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2"><font color="#000000">&nbsp;<b>Marquee</b></font></td>
    </tr>
    <tr>
      <td width="87" height="22">&nbsp;Syntax:</td>
      <td width="356" height="22"><font color="#FF0000">[marquee]</font>Text here<font color="#FF0000">[/marquee]</font></td>
    </tr>
    <tr>
      <td width="87" height="22">&nbsp;Example:</td>
      <td width="356" height="22"><marquee>Text here</marquee></td>
    </tr>
    <tr>
      <td width="443" height="22" colspan="2">&nbsp;<b>Code</b></td>
    </tr>
    <tr>
      <td width="88" height="22">&nbsp;Syntax:</td>
      <td width="355" height="22"><font color="#FF0000">[code]</font>Code here<font color="#FF0000">[/code]</font></td>
    </tr>
    <tr>
      <td width="88" height="22">&nbsp;Example:
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </td>
      <td width="355" height="22"><code>
		 #include &lt;iostream.h&gt;<br>
        int main()<br>
        {<br>
        &nbsp;&nbsp;&nbsp; cout &lt;&lt; &quot;Hello World!&quot;;<br>
        &nbsp;&nbsp;&nbsp; return 0;<br>
        }  </code></td>
    </tr>
  </table>
  </center>
</div>

<p align="center">[ <a href="javascript:history.back();">Back</a> ]</p>
<? displayFooter(); ?>