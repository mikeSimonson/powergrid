import pycurl
from urllib import urlencode

postfields = {'username': 'test_user_1', 'password': 'abcd1234', 'email': 'test_user1@testemail.com'}
postfields = urlencode(postfields)

powergridURL = 'powergrid.dev/user/register'

curl = pycurl.Curl()

curl.setopt(curl.URL, powergridURL) 
curl.setopt(curl.POST, True)
curl.setopt(curl.POSTFIELDS, postfields)
curl.perform()
