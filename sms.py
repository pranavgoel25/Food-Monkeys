# -*- coding: utf-8 -*-
import plivo
import sys

rnum = sys.argv[1]
message = sys.argv[2]
auth_id = "MAMGNLNDQ5Y2JKYMVHOT"
auth_token = "MjdkZDViMjE4NjcxOGMyOWRiMTU2MzI2ODk2YTYw"

p = plivo.RestAPI(auth_id, auth_token)


params = {
		    'src': '1111111111', # Sender's phone number with country code
			        'dst' : rnum, # Receiver's phone Number with country code
				    'text' : message, # Your SMS Text Message - English
#   'text' : u"こんにちは、元気ですか？" # Your SMS Text Message - Japanese
#   'text' : u"Ce est texte généré aléatoirement" # Your SMS Text Message - French
				        'url' : "http://example.com/report/", # The URL to which with the status of the message is sent
					    'method' : 'POST' # The method used to call the url
	}

response = p.send_message(params)

# Prints the complete response
print str(response)

# Sample successful output
# (202,
#       {
#               u'message': u'message(s) queued',
#               u'message_uuid': [u'b795906a-8a79-11e4-9bd8-22000afa12b9'],
#               u'api_id': u'b77af520-8a79-11e4-b153-22000abcaa64'
#       }
# )

# Prints only the status code
print str(response[0])

# Sample successful output
# 202

# Prints the message details
print str(response[1])

# Sample successful output
# {
#       u'message': u'message(s) queued',
#       u'message_uuid': [u'b795906a-8a79-11e4-9bd8-22000afa12b9'],
#       u'api_id': u'b77af520-8a79-11e4-b153-22000abcaa64'
# }

# Print the message_uuid
print str(response[1]['message_uuid'])

# Sample successful output
# [u'b795906a-8a79-11e4-9bd8-22000afa12b9']

# Print the api_id
print str(response[1]['api_id'])

# Sample successful output
# b77af520-8a79-11e4-b153-22000abcaa64
