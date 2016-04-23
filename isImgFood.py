#!/usr/local/bin/python
import os
#os.system("/Users/rupalsanghavi/Box Sync/Databases/VM/zero-to-slim.dev/src checkImageFood.php image")
import sys
from clarifai.client import ClarifaiApi
#print(sys.path)

clarifai_api = ClarifaiApi()
result = clarifai_api.tag_image_urls(sys.argv[1]) #get image var from php file
print("Rupal")
#result = clarifai_api.tag_image_urls('http://res.cloudinary.com/doazmoxb7/image/upload/v1460929747/noodles_c4gq9p.jpg') #get image var from php file

#result = clarifai_api.tag_images(open("http://res.cloudinary.com/doazmoxb7/image/upload/v1460929747/noodles_c4gq9p.jpg",'rb')) #get image var from php file

#result = clarifai_api.tag_images(open(sys.argv[1],'rb')) #get image var from php file
#result = clarifai_api.tag_images(open('/Users/rupalsanghavi/Documents/burrito.png','rb'))
isFood = False
for x in result['results'][0]['result']['tag']['classes']:
    if x == 'food':
        isFood = True
        print("Food!")
        break

if isFood == False:        #os.system("php /Users/rupalsanghavi/'Box Sync'/Databases/VM/zero-to-slim.dev/src/checkImageFood.php false")
    print("Not Food!")

        #os.system("php /Users/rupalsanghavi/'Box Sync'/Databases/VM/zero-to-slim.dev/src/checkImageFood.php true")
