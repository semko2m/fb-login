#Laravel app testing for application

#app url : http://www.sehara.eu

Requirements :

Implement a Facebook app with the following features and do not invest more than 5 hours. You do not have to start immediately. Instead you can choose when you would like to start with the task. Don't worry if the app will not be finished within the above outlined time frame, just send us what you will have developed till then. And here comes more information:

Please use PHP and MySQL (innoDB) as database. Make sure to implement a clean, well-structured and high-performance database scheme
The user should connect/login with Facebook (logout accordingly) The user data should be saved in the MySQL database.
The Facebook app should simply provide the following output: the name and profile picture of the logged-in user
The token, which will be stored for the user in the database, should be a long living access token
If the user removes the Facebook app, the user shall be marked as "is_active = false" in the database (Note: Facebook deauth callback)
Please be efficient when writing your code and commit your code in a github.com repository. Pay attention to clean commits
Weitere Hinweise / weiterführende Links

https://developers.facebook.com/docs/facebook-login/access-tokens

https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.4

https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.1#deauth-callback


#####Notice : 
    -If you change url you must change url on app in the facebook dashbord settings app.
    Username : +38269339179
    pass : 1kosarka1
    -Also change url in config services.php (calback url line 40)
    -If you have problems with curl : 
    Adjust your appache : 
    https://laracasts.com/discuss/channels/general-discussion/curl-error-60-ssl-certificate-problem-unable-to-get-local-issuer-certificate/replies/37017
    -When you login you have active users that didn't delete facebook apps from their account and you have not active.
    -You must run migration 

###Used  laravel/socialite package


s

