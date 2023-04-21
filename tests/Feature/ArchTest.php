<?php

// Makes sure the application doesn't use debugging functions
it('does not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

// Makes sure only the Redirect facade is being used in the Controllers
it('uses the redirect facade for redirecting')
    ->expect(['back', 'redirect', 'to_route'])
    ->not->toBeUsedIn('App\\Http\\Controllers\\');