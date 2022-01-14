<?php
/**
 * This script creates the security report page
 */
    ini_set("session.save_path", "/home/unn_w19031546/sessionData"); //set session folder location
    session_start(); //start a new session
    require_once('scripts/functions.php'); //link to the functions.php script file
    echo makePageHead("Security Report"); //create the html header and start the body. The page title is passed as an argument
    echo makeNavMenu(); //create the navigation menu
    echo startLightSection(); //create a new light section
?>
    <h2 class='text-centre'>Security Report</h2>
    <h3 class='text-centre'>Introduction</h3>
    <p>
        Security is an integral part of website design. According to Statista, the average cost of cyber security breaches to UK businesses was £2,670 in 2021 (O'Dea, 2021). A Government survey of cyber security breaches reveals that this number is higher for larger businesses. For medium sized businesses the cost is £8,460 and for medium and large businesses combined it is up to £13,400. The survey also claims that 39% of businesses report at least one breach in the last 12 months and of those, 27% report at least one breach a week (Department for Digital, Culture, Media & Sport, 2022).
    </p>

    <h3 class='text-centre'>Security Measures Taken</h3>
    <p>
        This website allows users to browse villas and make reservations. Only registered and logged in users are permitted to make a reservation. To verify a user has logged in successfully, PHP Sessions are used. The PHP Sessions on this website store the username and a logged-in flag that is set to true when a log in is successful. Sessions allow these variables to be saved on the server. As HTTP does not maintain the state, session variables are used to verify the user is who they say they are and that they are authorised to view the page they are on. On each restricted page on this website, the PHP code checks the session variable to make sure one exists and that the Boolean logged-in is set to true. If it is the user is allowed to view the page. If not they are immediately redirected either to the home page or the login page.
    </p>
    <p>
        In this website most of the data processing is handled by separate scripts. For example, the register.php file contains all the content necessary to displaying the page such as the HTML form. The form passes the data to a separate registerProcess.php script that verifies the data and passes it to the database. This process script can be accessed by it's URL. Although it is unlikely that a normal user would stumble across the script by accident, there remains a small chance the script could be accessed in a manner other than by the registration form. Users should not be able to access scripts in this manner especially when the scripts connect to the database. To protect against this, an if statement checks for the presents of a super global POST  that is set when the form is submitted. If one does not exist the page redirects to the register.php page.
    </p>
    <p>
        One of the most serious threats to database driven websites is SQL injection. This is a security exploit where a bad actor can enter SQL code into a text box and submit it to the database where it is processed. The code they add to the textbox will alter the structure of the SQL query. At best this could be manipulating a login script into bypassing any password verification by always returning true. At worst entire database tables can be dropped. This type of attack can be mitigated by using Prepared Statements. A prepared statement allows an SQL query to be written using placeholders. The query statement and the form data are sent separately thus allowing the data to be entered into the table in a way that does not allow SQL code written into the form to interact with the statement code itself (Thomas, Williams and Xie, 2009). 
    </p>
    
    <h3 class='text-centre'>Things to Improve</h3>
    <p>
        A recognised limitation of the University's web server is the lack of Secure Socket Layer (SSL). This means HTTPS cannot be used. In a real world application this would present a major security risk. HTTP sends data between the client and server unencrypted. Because of this, hackers can intercept network traffic and have access to the data being sent such as usernames, emails, and passwords using a sniffing attack (Cloudflare, 2022). This website attempts to secure user data specifically passwords which are stored as a hash rather than plain text. However, as the hashing process is done server-side, the unhashed passwords are sent unprotected. 
    </p>
    <p>
        A Distributed Denial of Service attack (DDoS) is where a website's servers are overloaded with network traffic and crash. A DDoS attack uses multiple already compromised systems, often referred to as bots, to bombard the target system with malicious or innocuous packets of data (Osanaiye, Choo, Dlodlo, 2016). Depending on how the website is built on the backend this could result in a minor inconvenience of the website being inaccessible for a period of time up to the loss of data that may not have been processed and saved yet. In either case, a DDoS attack can be incredibly damaging to a system. One solution, not implemented on this website, would be the use of a CAPTCHA system. One of the most popular systems in use today is reCAPTCHA developed by Google. However, CAPTCHA systems are not infallible to attack. A study of CAPTCHA farms conducted in 2010 found that the cost of solving 1 million CAPTCHA's manually was only $1,000 (Motoyama et al., 2010).
    </p>

    <h3 class='text-centre'>References</h3>
    <p>
        O'Dea, S., 2022. UK businesses: average cost of security breaches 2021 | Statista. [online] Statista. Available at: <https://www.statista.com/statistics/586788/average-cost-of-cyber-security-breaches-for-united-kingdom-uk-businesses/>.
    </p>
    <p>
        Department for Digital, Culture, Media & Sport, 2022. Cyber Security Breaches Survey 2021. [online] GOV.UK. Available at: <https://www.gov.uk/government/statistics/cyber-security-breaches-survey-2021/cyber-security-breaches-survey-2021> [Accessed 7 January 2022].
    </p>
    <p>
        Thomas, S., Williams, L. and Xie, T., 2009. On automated prepared statement generation to remove SQL injection vulnerabilities. Information and Software Technology, 51(3), pp.589-598.
    </p>
    <p>
        Cloudflare.com. [online] Available at: <https://www.cloudflare.com/en-gb/learning/ssl/why-is-http-not-secure/> [Accessed 7 January 2022].
    </p>
    <p>
        Osanaiye, O., Choo, K. and Dlodlo, M., 2016. Distributed denial of service (DDoS) resilience in cloud: Review and conceptual cloud DDoS mitigation framework. Journal of Network and Computer Applications, 67, pp.147-165.
    </p>
    <p>
        Motoyama, M., Levchenko, K., Kanich, C., McCoy, D., Voelker, G. and Savage, S., 2010. Understanding CAPTCHA-Solving Services in an Economic Context. USENIX Security Symposium.
    </p>

<?php
    echo endSection(); //close the section
    echo makeFooter(); //create the footer
?>