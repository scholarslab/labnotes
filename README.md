# Deployment

## Install dependencies

```shell
$ cd path/to/plugin
$ npm install
```

## Deploy

You will need a magic file `.configs.json` for this to work. The file
needs to look like this:

```json
{
     "prod": {
         "host": "user@server",
         "dest": "path/to/wp-content/themes/labnotes"
     }
}
```

After this file exists, you can deploy the theme with the following
comand:

```shell
$ grunt deploy
```
