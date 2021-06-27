# Zendesk Product Security
### The Zendesk Product Security Challenge

#### To run the application:

1. Install XAMPP server https://www.apachefriends.org/download.html.
2. Copy the entire folder (/product_security_challenge) to the /htdocs folder.
3. For the mail password reset we need to setup the gmail smtp server details.<br />
   Copy and replace \xampp\php\php.ini with \config\php.ini<br/>
   Copy and replace C:\xampp2\sendmail\sendmail.ini with \config\sendmail.ini<br/>
   Which contains the SMTP configs.
4. Run the queries \config\queries.sql
5. Start the XAMPP server.
6. Application can be accessed via http://localhost/product_security_challenge/project/ 

#### Screenshots are available in /screenshots directory.

#### For testing go here https://zendesk-challenge.000webhostapp.com/project/ (Password reset mail is not setup in this server)
**The above server may not be resilient, since it's a testing platform.

#### Items completed:
- [x] Input sanitization and validation
- [x] Password hashed
- [x] Password reset / forget password mechanism
- [x] CSRF prevention
- [x] Prevention of timing attacks
- [x] Logging
- [x] Multi-factor authentication
- [x] Account lockout
- [x] Known password check
- [ ] HTTPS
- [ ] Cookie
