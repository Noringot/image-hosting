 # Installation instructions
 - git clone git@github.com:Noringot/image-hosting.git
 - composer install
 - npm i
 
 ## Insert information about database and ftp in .env file(example in .env.example)
<p>
  <div>DB_CONNECTION=mysql</div>
  <div>DB_HOST=</div>
  <div>DB_PORT=</div>
  <div>DB_DATABASE=</div>
  <div>DB_USERNAME=</div>
  <div>DB_PASSWORD=</div>
</p>

<p>
  <div>FTP_HOST=</div>
  <div>FTP_USERNAME=</div>
  <div>FTP_PASSWORD=</div>
</p>

## Running migration and start project
- php artisan migrate
- php artisan serve
- npm run dev
