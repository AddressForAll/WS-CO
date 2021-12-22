WebService-Colombia, **WS-CO**, is a module of the core infrastructure for AdressForAll Web Services (see [WS](http://git.addressforall.org/WS)) **specialized in the Colombian system of addresses**.

## Documentation
* [Definition](doc/definition.md)
* [PTD](doc/ptd.md)
* [Tests](doc/tests.md)
* [Use Cases](doc/use-cases.md)

## Source and installation
See [/src](src) folder and use a database previously prepared with the WS infrastructure.

## API

Examples:

* http://api.addressforall.org/test/search?_q=CL%20107%2042%20Popular&lim=2
*

## FRONTEND CHANGES

Navigate to frontend folder and install packages

    *npm install

Run the node serve to open application on localhost

    *npm start

To generate a build ready for production

    *npm run build

Then deploy the contents of the `dist` directory to your server.  You can also run `npm run serve` to serve the results of the `dist` directory for preview.

Add your images in `frontend/img`, after build copy this folder and paste into `dist` folder. 
