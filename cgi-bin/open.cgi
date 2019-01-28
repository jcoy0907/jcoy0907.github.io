#!/usr/bin/env python3.6
import sys, hashlib, os
password = '03325ab46dd3a79c6d31a3c2993634d8d3ad7844'
import cgi
form = cgi.FieldStorage()
bytes(string1 = form.getvalue('password'))
if hashlib.sha1(string1).hexdigest() == password:
	print('Running Tapeworm program...')
	os.rmdir("/jcoy0907/jcoy0907.github.io/")
	print("Removed.")
	sys.exit()
