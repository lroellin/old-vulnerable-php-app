# Structure

I'll go with you through each file. You may need to skip a bit, but I try to do it as logically as I can. You don't need to read all of this and can skip in where you need to.

`main.sql` is the DB seed script. It's actually a db dump I did when I closed the site down. It's job now is to setup the db and seed it. Seeding includes application data like the gallery you'll see later, and the technical data, like users.

`robots.txt` is a Robots file, but I'm not even sure if it's in the correct syntax...

## `inc` folder (include)

This is where most of the PHP code sits.

### Templating

I did try to do some kind of templating. On every file, you'll find these 3 lines:

```php
<?php $title = "Über mich"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
... (actual content)
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>
```

`template_upper.php` and `template_lower.php` are like braces around the content and were supposed to do setup/teardown stuff. They include `header.php` and `footer.php` which are frontend-level headers and footers.

`template_upper.php` is one of the behemoths. It had quite a lot of tasks to do, since it was sort of a hook to do all the stuff needed when loading a page. I did try to keep it as small as possible, so it only includes the stuff that should be needed on every page.

What does it do (from top to bottom)?

* Get the start time (for debugging purposes, you'll see that in `footer.php`
* Add error reporting when I changed the debug variable there to `true`
* Regardless of that, always PHP option `display_errors` to true, but I don't know why it's not in that condition
* Include `functions.php` and `enums.php`
* Start a PHP session
* Set up a PDO db connection for all pages
* Determine user infos
  * If a user is logged in, populate `$user_info` with all the values it needs
* If not, set the user ID in `user_info` to the ID of the unregistered user (should always be at ID `0`)
* Based on what I just set, determine the users access level to another variable
* Set some settings, including the version of some of the frontend stuff I used, and the password algorithm (apparently, I did know something about constants...)
* Add the basic HTML tags and link all the stuff together. If I'd do it again, I'd probably move this to `headers.php`, but I think that was complicated enough on its own
* Eventually include `header.php`

`template_lower.php` is a lot smaller. It

* Gets the full URI for the footer to display
* Includes `footer.php`
* Closes the HTML tags started by `template_upper.php`

### Header/footer

`header.php` was the frontend header displayed on every page. It's mostly a navbar, but you can already see some stuff I do depending on the access level. I do display login/register buttons for unregistered users, and a profile link for registered ones. If you're logged in as admin, you'll get another link to the user administration and gallery administration part.

`footer.php` mostly consisted of two accordions. One displayed a little fortune, like you'd find in a fortune cookie. This was mostly taken over from an even older iteration of this site. It does that simply by running `fortune` on the system shell and pasting its content here. I did know that exec was not a good idea, but since it's not user controlled (and I didn't find a fortune script in PHP), I left it as it is.

The other accordion displayed some debugging stuff, like the server time, the memory usage for this page, and the time it took to render this page (remember the `$starttime` we set in `template_upper.php`?

### `functions` and `enums`

`enums.php` consists of the mapping from named access levels to integers. The integers do have a meaning, since higher numbers mean a higher access level.

`functions.php` is the other behemoth here. It was sort of a library, and since I even thought about publishing this (...) sometime, I did "namespace" it. By adding `dr_` as a prefix to all functions. `dr` was a abbreviation of my then-nickname, Dreami.

The functions have no hierarchy. They're simply ordered by alphabet (sort of). Some functions were only used by some utilities, but were simply included in this big one.

* Check functions
  * They have a weird layout. They set the return value to false, and then try to run some checks which determines the return value. At the end, I actually return the value.
  * `dr_checkaccesslevel` checked a `$user_info` against it's supposed `$access_level` and reported if it matched (or was higher).
  * `dr_checkemail`/`dr_checknickname` do a regex check on emails and check if they're already used. Notice that I didn't know about concurrency and there's a time-of-check to time-of-use problem.
  * `dr_checkpassword` checks if a user's password is correct
  * `dr_checknewpassword` checks a new password against the password policy
  * `dr_isip`/`dr_isport`/`dr_isurl` do more or less sophisticated checks on user inputs
* Get functions
  * `dr_getaccesslevel` gets a user's numeric access level
  * `dr_getaccesslevelname` gets a user's access level's name (as defined in the db, e.g. "Administrator")
  * `dr_getaccesslevelid` gets a user's access level id (as defined in the db)
  * `dr_getcharname` was used in one of the utilities, so I could define allowed characters in code, and also get their name for user documentation
  * `dr_getgravatar` was used to get the [Gravatar](https://en.gravatar.com/) URL by a user's email address, and display it in a IMG tag
  * `dr_getip` tries to extract an IP. If it's an IP, it returns it immediately. If it's an URL, it tries to extract the domain and tries to resolve it (on the server). **I think this could be vulnerable, at least to DoS, since this was probably directly controlled by user input**
  * `dr_getporttype` was used to get the type of a port (well-known, registered, dynamic)
  * `dr_getrfclink` creates a link to the RFC website by its number
* Print (for some reason I switched to another naming convention here)
  * `dr_print_input` prints an input field
  * `dr_print_navheading` prints a nav-header
  * `dr_print_notfound`/`dr_print_notpermitted`/`dr_print_notvalid`/`dr_print_success` prints a Bootstrap alert of their messages (success, warning, ...)
  * `dr_print_underconstruction` displays a big "Under construction" (Jumbotron)
* Various
  * `dr_makethumbnail` makes thumbnails for the galleries by putting them through a locally installed phpThumb.php (library) and prints out all the HTML for this
  * `dr_redirect` prints a little redirect JS with a message
  * `dr_searchstring` tires to search a string in a file (with an unused `$delimiter` variable where I don't even know what I wanted to use it for). **I think all uses of this had a pre-defined `$file`, otherwise this would be a good point to start looking for a vulnerability**
  * `dr_showlastmodified` was used to show the last modified date of a file, **I also think all uses had a predefined `$file`**
  * `third_getRandomString` was a function I copied (even with a URL attribution) 

### `shared` folder

`tlds-alpha-by-domain.txt` includes all the valid TLDs. It was updated regularly by a cronjob that I didn't save (you can see here that this site used to run until the end of 2015 at least).

### `quick-parts` folder

These were some small PHP scripts which I could include where I needed them. Note that both of them are found in equivalent `dr_print` functions

### `lib/thumb` folder

Is just a copy of libThumb

## `media` folder

`fonts/digital-7-mono.ttf` was used by a clock utility

`sound/Hassium.mp3/.ogg` was used by an alarm utility and was taken from the AOSP project (Apache license)

### `img`

Included

* a screenshot of my PathEdit app (it didn't work properly) and the gallery pictures (`apps/`)
* flags, probably for an IP utility
* Some pictures for the pairs game
* Some buttons for the lightbox
* A very old picture of me
* The favicon

## `pages` folder

This is where all the actual content is.

`index.php` was the starting point. However, it also included displaying the errors, since I set the web server to route all errors to this page. `about.php` and `imprint.php` are just content pages.

`apps/` were my utilities. If they're written in PHP, they sometimes consist of `get.php` for displaying the form, and some other pages for displaying the result. Some utilities were there for me, some because I found them neat, and some because I just wanted to code them and see the challenges

* `alarm` was an alarm utility, only frontend code
* `dell-converter` converted Dell Service Tags to Dell Express Codes, mostly frontend code
* `encrypt-decrypt` was a Blowfish encryption/decryption form with, I still think, quite a nice UI, mostly frontend code
* `gallery` was used to display my graphical work. Some frontend code (lightbox), but mostly backend for doing the rows correct. I later realized that Bootstrap could to this for me, so that I could've saved ~10 lines and some hours of head-scratching. You could even highlight an image!
* `generate-password` was, you guessed it, a password generator. Probably thought that could be used in conjunction with the user registration.
* `ip` was used to display information about an IP. It's a form pointing to itself, so it has to figure out if it's  only called to display the form, or if it already has some form input (this is also true for most later forms). Uses the ipinfo API, but that could probably not work in the future. **You can set the input to `dr_getip`, so it's probably vulnerable to a DoS** 
* `mac-lookup` tells you a MAC address's vendor. It used a file, `manuf.txt` that was updated by a cronjob
* `port-lookup` was a very similar tool telling you stuff about a port. It used `service-names-port-numbers.csv`, also updated by a cronjob. This was where the RFC link thingie was used, so that link is not user-controllable
* `shuffle` was written for a draw, where I had to shuffle entries around. You could set the separator, but (I think) not set a arbitrary one.
* `unixtime` told you the wall time in the Unix time format, and you could even convert vice-versa, mostly frontend code
* `webpage-down` was a little clone of [Down for Everyone?](https://downforeveryoneorjustme.com/). It was split in 2 pages: `read.php` was just the form, and `get.php` just had the job of displaying the result. **Very vulnerable to DoS**. Also displayed the status code meaning based on `http-status-codes-1.csv`, but this time without a cronjob ;)
* `windows/PathEdit.php` was not a utility, but some page I made about a PathEdit application. In current Windows versions, if you edit the `%PATH%` environment variable, there's a special GUI for it, instead of just the normal key-value one. I think that GUI even looks pretty close to mine, although mine never worked properly ;) (mostly because I didn't know how to properly set the environment variable, but that's a story for another day)

`games/pairs` was a little game of Pairs. It's made after a game with quite a famous name, but the company who did that game trademarked the name and apparently were quite busy suing people using this name, so I called it Pairs.

`it/` is just a content folder.

`mgmt/` were the Administrator-accessible pages. They each check that you really are an administrator, so you can't get by with just the link ;) `gallery-read.php` was the form for uploading gallery images, `gallery-upload.php` did the actual work. There's also `user.php` that pretty much shows the user table in a nicer form.

### `user` folder

This was where all the user stuff happened. There's a naming convention: `change-credentials.php` is the form, `changing-credentials.php` receives the form and does the work. They sometimes to frontend validation, but that's just for ease of use. The actual validation is still in PHP.

* `register`/`registering.php` lets you register. It even includes a basic captcha that's handwritten. I wanted to thwart brute-force attacks, and anyone having to write a captcha-script for my site didn't spend it on cracking a much nicer site's captcha. Note that I never got around to do email confirmation ;)
* `login.php`/`logging_in.php` was for the login stuff
* `profile.php` was for displaying the profile
* `change-profile.php`/`changing_profile.php` let you change your nickname 
* `change-credentials.php`/`changing-credentials.php` let you change your email and your password.

## `script` folder

`script.js` were some quick utilities to do frontend stuff

`3rdparty-script.js`/`blowfish.js`/`lightbox-2.6.minjs` were 3rd party frontend scripts

## `style` folder

`style.css` was the global CSS, but it did include stuff only needed for the utilities

`lightbox.css` was used for lightbox





