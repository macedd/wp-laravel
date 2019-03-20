# Laravel Integration for WordPress

### Rationale

When projects grow in complexity, having a full featured framework can drastically improve the quality of the codebase - including performance, reusability and testability.

Integrating Laravel to a WordPress run-time can provide numerous use-cases a cutting edge environment and tools inside the well known WordPress frontend.

Examples include, but are not limited:

- Modeling data in a sensitive manner with Eloquent
- Deploying distributed Queues for background jobs
- Building Notification systems
- Creating custom Search Engines
- Reuse any of the Laravel backend components (including the ones from the community)
- Anything your business needs

### Deployment

This setup requires both codebases to sit side-by-side in the servers.

What the plugin does is to `include` Laravel run-time inside WordPress, so them have to be accessible and installed from within the same server instances.

Typically we have 2 repositories, one for each of the codebases.
The deployment is done when necessary and the Laravel install have to be fully done (with composer).

There is no need to serve Laravel from the same instance, thought. It's just the codebase.

See usage and installation details on the plugin [readme.txt](wp-laravel/readme.txt).
