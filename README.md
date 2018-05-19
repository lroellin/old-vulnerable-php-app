# old-vulnerable-php-app

This is a PHP app that I wrote ca. 2013. 

# Don't judge

If anyone comes across this code, don't think this is how I'd structure a program today ;)

It's probably a good example of a programmer vs. a software engineer. I was still in an apprenticeship studying more of the infrastructure part of CS, and was only self-teaching me some programming stuff. You can see this very much in how the code is structured (especially the inclusion of my "library" everywhere). I remember thinking if this is the right way to do stuff, but since I didn't know the jargon to search for, I didn't know what do look for.

# Why are you even uploading this then?!

The goal of this project for me would be for someone to audit it. Why?

As my apprenticeship was in a IT security company, though specialized on IT infrastructure security, I got quite an interest in it. So, I really wanted to keep the code secure.

At that point in time, a lot of hobbyist programmers were using PHP. So, the code they shared was far from good most of the time, and most of the code snippets were outdated. I'm not saying that all PHP apps were bad if designed properly, just that most apps didn't have any design part behind them. I did know that already, so for everything I did, I had a look at what the most secure way to do this was.

In losing my humbleness a bit, I think this code can show what a hobbyist PHP programmer could do when wanting to do something secure, without any further knowledge other than searching the web. I'd really like to know what I missed, and if I find the time, I'll even have a look at it myself.

# The code

The code is uploaded as-is. The only parts I changed:

* Remove a user from the db (yes, one colleague even registered)
* Remove my (old) email address from the db dump
* Rewrote .htaccess (RewriteRules were not part of the backup)
* Moved `<!DOCTYPE html>` to a lower line in `template_upper.php` don't know how that ever worked (headers already sent-problem)
* Dockerize it


Yes, the DB password and the admin user password (hashed) are in the code as-is. I've never used them anywhere else, and since this is what it was like, I won't change it ;)

Note that some stuff is, unfortunately, in German. That only includes stuff that's visible to the users, all the code is written in English. I even think that you can guess what is there, based on where it is visually is on the page, like the "Anmelden" (login) and "Registrieren" (register) part in the top-right.

# Known issues

* The `ip` displays an error when starting, since it tries to display stuff about your IP. However, since you're connecting via a private IP, it filters it out.
* The `mac-lookup` utility doesn't know many modern MAC address vendors. Choosing the placeholder value works though.
* The `unixtime` converter utility doesn't calculate properly, but that's frontend code anyway...
* The `alarm` utility has some frontend issues too ;)

# Auditing

If you find an issue, open a Github issue!

I think the best way to discuss all the vulnerabilities found in this code is to open an issue on Github. That way, everyone can see what is already found. If you want to show how it's done right, you could even open a Pull Request.

Don't expect for me to fix any issue or merge this though ;) The code should stay as it is, for others to admire.

## What's out of scope?

* Direct db connections. There were iptable rules that didn't allow a db connection from the outside
* Technically, there was a webmin installation available and you could probably take over the system just with that. However, that is also out of scope, since that would be too easy
* SSH connections were possible, but were only allowed with a certificate## What is it probably vulnerable to?

I paid no attention to:

* XSRF

I only paid a little attention to

* XSS

## What should it not be vulnerable to?

* SQL injections (I used Prepared Statements)

# What was the site like?

It was mostly a personal site. I showed off some of my work (a little graphics gallery), and it included some info about me. I also includes some utilities, some were written in PHP, some in JS. I do remember making a distinction between them and only running the ones on PHP where I needed backend code, mostly because I didn't want the client to download a little database.

## Users

It also included a user part that was hand-written. That's probably where most of the stuff could go wrong, but also where I did try to make it as secure as possible.

A user, once logged in, could do absolutely nothing more than look at his profile. There was an admin user though (it even had access levels, so it was just a user with the admin role) that I used to upload images to the gallery. The admin-accessible parts assume you're not doing something wrong, so they're not as secure as they could be. As an example, the upload script doesn't try to do do any fancy validation, so you could upload whatever you wanted.

### Why did you even include users then?

It was mostly a coding and security challenge.

# Code documentation

See [Structure](structure.md)

# License

My code is usually MIT. However, I can't be sure if I didn't copy code from somewhere else without attribution (there's e.g. phpThumb directly included which is GPL), and I sure didn't check any license. So I sure can't give any license, unless I have to.
