const hotMiddlewareScript = require('webpack-hot-middleware/client?noInfo=false&timeout=20000&reload=true&quiet=false');

hotMiddlewareScript.subscribe(event => {
  if (event.action === 'reload') {
    window.location.reload();
  }
});
