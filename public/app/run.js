'use strict';
/**
 * Run Config
 */
function runConfig($route, $rootScope, $location) {
  var original = $location.path;

  $location.path = function (path, reload)
  {
    if (reload === false)
    {
      var lastRoute = $route.current;
      var un = $rootScope.$on('$locationChangeSuccess', function () {
        $route.current = lastRoute;
        un();
      });
    }
    return original.apply($location, [path]);
  };
};

angular
	.module('app')
	.run(runConfig);
