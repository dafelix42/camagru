# camagru
Instagram like web application

# User features
• The application allow a user to sign up by asking at least a valid email address, an username and a password with a standard level of complexity.

• At the end of the registration process, the user should confirm his account via a unique link sent at the email address fullfiled in the registration form.

• The user is able to connect to your application, using his username and his password. He also should be able to tell the application to send a password reinitialisation mail, if he forget his password.

• The user is able to disconnect in one click at any time on any page.

• Once connected, an user should modify his username, mail address or password.

# Gallery features
• This part is public and display all the images edited by all the users, ordered by date of creation. It also allow only a connected user to like them and/or comment them.

• When an image receives a new comment, the author of the image is notified by email. This preference must be set as true by default but can be deactivated in user’s preferences.

• The list of images are paginated, with 6 elements per page.

# Editing features
This part is accessible only to users that are authentified/connected.

This page contain 2 sections:

• A main section containing the preview of the user’s webcam, the list of superposable images and a button allowing to capture a picture.

• A side section displaying all previous pictures taken.

• Superposable images are selectable and the button allowing to take the picture is inactive (not clickable) as long as no superposable image has been selected.

• The creation of the final image is done on the server side, in PHP.

• Because not everyone has a webcam, I allow the upload of a user image instead of capturing one with the webcam.

• The user is able to delete his edited images, but only his, not other users’ creations.
