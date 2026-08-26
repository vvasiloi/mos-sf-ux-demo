## Why choose backend rendering with PHP instead of an SPA with JavaScript?

### Simplicity

PHP, and especially the Symfony framework, has a fairly straightforward development process, making it easier and faster to develop applications

### Productivity

Symfony framework and the PHP ecosystem as a whole has a lot of tools that boost developer productivity and facilitate rapid development.

### No more JS in the backend

The Symfony UX components allow to completely remove the JS from the backend.
No more node_modules, Node.js, Yarn, NPM, Webpack, etc.
This significantly reduces the complexity of the application as well as it's development and maintenance cost.

### Less JS in the frontend

The Symfony UX also comes with alternative solutions to the common problems of building interactive frontends that are usually solved with heavy JavaScript frameworks and libraries.
For example, it seemingly integrates with Hotwire's Stimulus and Turbo:

- https://symfony.com/bundles/StimulusBundle/current/index.html (https://stimulus.hotwired.dev/)
- https://ux.symfony.com/turbo (https://turbo.hotwired.dev/)

This low reliance on JavaScript greatly reduces the potential issues related to browser compatibility and front-end dependencies.

### Performance and Load Time

Backend-rendered pages are often faster to display initial content because the server generates the HTML, reducing the time required for the browser to render the content.
Hosting the PHP application in K8s and allowing it to connect to the API through the internal network will make the additional network time less significant.
In cases where rendering one page requires multiple requests to the API it might actually be faster due to reduced time for the trips on the internal network as opposed to over-the-internet with JavaScript.

### Security

Sensitive logic and processing are done server-side, potentially reducing exposure to common client-side vulnerabilities such as Cross-Site Scripting (XSS).

### Consistency across devices

Since the server renders the content, it ensures consistent presentation and behavior across different devices and browsers.

### Session management

Server-side session management is simpler and more secure with PHP, compared to managing sessions entirely in a client-side SPA.

### Team

We have highly experienced devs at ready, each with a decade of experience developing web applications, primarily with PHP and specifically Symfony.
