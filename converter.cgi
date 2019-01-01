#!usr/bin/python
import cgi, base64
form = cgi.FieldStorage()
string1 = form.getvalue('string1')
string2 = form.getvalue('string2')
print("""Context-Type: text/html

<!DOCTYPE html>
<html>
	<head><title>jcoy0907's converter</title></head>
	<body>
		<h1>jcoy0907's converter</h1>
		
		
		
		<form action='converter.cgi'>
		Enter unencoded string (no quotes):
		<textarea name='string1' cols='40' rows='20' />
		Encoded String:
		<textarea cols='40' rows='20'>{0}</textarea>


		<br />


		Enter encoded string		
		<textarea name='string2' cols='40' rows='20' />
		Decoded String:
		<textarea cols='40' rows='20'>{1}</textarea>
		</form>
	</body>
</html>
""".format(repr(base64.b64decode(repr(string1))), repr(base64.b64decode(repr(string2)))))
