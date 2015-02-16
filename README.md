# fourdivisions-server

Just writing code and seeing where it takes me...
(In progress)

So far, this has turned into an MVC framework that seems to have been inspired (at least in naming conventions) by .NET's MVC. For better or for worse.

The end goal is to have a server-side implementation of a chess application that can either directly serve content or expose that content via API calls (likely JSON-RPC).

I'm attempting to develop this quickly, adding enough value from the start so that it is actually usable. To that end, I'm introducing feature debt that can be filled in later (e.g. the storage mechanism uses text files rather than a database [more likely, a NoSQL implementation]). Memcached is used for storing data that is allowed to be 'temporary', but is not currently used to actually cache any valuable persistent data (like the data in the flat files =]).

My primary TODOs are:
* Add the API (can release to production at this point and any point after)
* Develop simple client-side functionality (separate repo: fourdivisions-webclient)
* Implement actual users (currently allowing hard-coded credentials)
* Develop the Views to enable this project to be used directly

I'll get distracted from those goals and implement other behaviors in the meantime, but I'm okay with that.

# Quick Guide
The Bootstrap class is responsible for wiring up the routes. Each request includes a controller=x and action=y (e.g. https://host/?controller=MyController&action=MyAction). Those controller and action parameters do not directly correspond to a concrete Controller and it's method; rather, the Route object defines those. So a route can be configured for MyController to use a controller class "UserController" and the MyAction can be pointed at a method named "Login". The http method (GET/PUT/POST/DELETE) is automatically prepended to the method (with an "_" separating the http method and the function name. So:
* A request for MyController uses UserController
* A request for MyAction uses Login
* The http method used is "GET"
This will result in a call to UserController->GET_Login($params)

The $params is the $_REQUEST object, so any additional data sent along is available to that method.

The methods exposed via Route calls should return an implementation of ActionResult. Current ActionResult implementations are:
* RawResult (which returns the data, but makes no effort to print it to the response body)
* JSONResult (which encodes the content and the errors to a JSON object, intended to be used for XMLHTTPRequests)
* ViewResult (which provides the content to a separate .php file in a Views directory, allowing it to define what is rendered where).

The ActionResults expect a Model object, and that Model is made available via GetModel(). When using a view, the $this context is that of the ActionResult (ViewResult). Errors can be added to the Model and are consequently available via GetModel()->GetErrors().

# Warning
I'm not the most competent PHP developer; I haven't used it much in the last few years, and I've missed out on a lot of new functionality (like namespaces). To that end, there'll probably be a lot of stupid code in here. Feel free to point out mistakes and areas for improvements or just send me a pull request.
