# Workflow GULP + Stylus
![Stylus Gulp](http://bfmjr.com.br/git/gulp_stylus.png)
## Commands

Open your terminal and use the follow commands:

### Default
```` 
$ gulp
```` 
Are includes in this commands at follow tasks:
+ Stylus
+ JS

### BrowserSync
```` 
$ gulp sync
```` 
This command start server using BrowserSync, however must the url in the task, using a virtual host, follow exmaple:
I will  use `domain.local`. I use [XAMPP](https://www.apachefriends.org/pt_br/index.html) for development local. Not remember how refresh page long time ago :grin:

````javascript
 browserSync.init(["*.php", "js/*.js", "css/*.css", "*.html"], {
        proxy: 'domain.local',
        ghostMode: true,
        notify: false,
    });
```` 

### Sprite 
```` 
$ gulp sprite
```` 
This command generator sprite using at images in the folder `assets/images/sprite`, after it's servant an image in folder `images/` with name `sprite.png` and create `sprite.styl`, contains at variables corresponding. Follow example:

````sass
.my-icon
  sprite($icon-variable)
````
this is the result after compiled:
```sass
.my-con
  background-image: url('sprite.png')
  background-position: -176px -211px
  width: 12px
  height: 12px
````

### Deploy to ftp

````
$ gulp deploy
````
This command transfer the files according with the configuration. Follow example.

Step one: Configuration server

````javascript 
var conn = ftp.create( {
  host:     'HOST',
  user:     'USER',
  password: 'PASS',
  parallel: 10,
  log: gutil.log
} );    
````

Step two: Configuration files

````javascript
var globs = [
  'css/**',
  'js/**',
  'fonts/**',
  'images/**',
  '*.php',
  '.htaccess',
];
````

Step three: Configuration remote folder

````javascript
return gulp.src( globs, { base: '.', buffer: false } )
  .pipe( conn.newer( '/www/' ) )
  .pipe( conn.dest( '/www/' ) );
 ````
