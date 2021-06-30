# PHP sms library to send sms with http/rest api

This PHP sms library allows you to **send**, **receive**, **delete** and **mark** messages from PHP with http requests.
The library uses HTTP Post requests and JSON encoded content to send the text messages to the mobile network.
It uses the HTTP SMS api of the [Ozeki SMS gateway](https://ozeki-sms-gateway.com)

# What is Ozeki SMS Gateway

Ozeki SMS Gateway is a powerful and reliable SMS Gateway software that can be installed to Windows, 
Linux and to an Android phone as well. Your data is in safe hands with the Ozeki SMS Gateway because it runs 
in an environment that only you control. It provides an HTTP SMS API, that allows you to connect to it 
from local or remote programs. It is totally independent from service providers, so It could be used in any country, 
offering direct access to service providers through wireless connections. 
This library enables you to use the Ozeki SMS Gateway as your SMS Gateway.

Download: [Ozeki SMS Gateway download page](https://ozeki-sms-gateway.com/p_727-download-sms-gateway.html)

Tutorial: [How to send SMS from PHP](https://ozeki-sms-gateway.com/p_852-php-send-sms-with-the-http-rest-api-code-sample.html)

## How to send sms from PHP:

**To send sms from PHP**
1. [Install Ozeki SMS Gateway](https://ozeki-sms-gateway.com/p_727-download-sms-gateway.html)
2. [Connect Ozeki SMS Gateway to the mobile network](https://ozeki-sms-gateway.com/p_70-mobile-network.html)
4. Create a HTTP sms api user
5. Start Wamp server
6. Download the example above
7. Create the SMS by creating a new Message object
8. Use the SendSingle method to send your message
9. Read the HTTP response
10 .Check the logs in the SMS gateway

## How to use the code

To use the code you need to import the Ozeki.Libs.Rest.Php sms library, which gives you all the tools neccessary to send and receive SMS messages. 
This sms library is also included in this repository with it's full source code. 
After the library is imported with the using statement, create a user with a username of "http_user", 
and with a password of "qwe123" to make the example work without modification.
The URL is the default http api URL to connect to your SMS gateway.
Note that the IP address (127.0.0.1) should be replaced to the IP address of your SMS gateway.

```
namespace Ozeki_PHP_Rest
{
require 'MessageApi/MessageApi.php';
 
        $configuration = new Configuration();
         
        $configuration -> Username = "http_user";
        $configuration -> Password = "qwe123";
        $configuration -> ApiUrl = "http://192.168.0.113:9509/api";
         
        $msg = new Message();
         
        $msg -> ToAddress = "+36201111111";
        $msg -> Text = "Hello, World!";
             
        $api = new MessageApi($configuration);
         
        $result = $api -> SendSingle($msg);  
         
        echo strval($result);
}
```
## Manual:
In order to understand the **SMS code sample** better, we provide you a manual webpgae that explains this code in a detailed way with the help of video tutorials.
You can get the downloadable content and the explanatory screenshots on the webpage aswell.
Link: [How to send sms from PHP](https://ozeki-sms-gateway.com/p_852-php-send-sms-with-the-http-rest-api-code-sample.html)

## Get started now

Don't waste any time, start working with the repository and send your first SMS!

