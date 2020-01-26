Create an old version of unit tests here with u at beginning, example uProjectName

Info about old version of units [here](https://github.com/laravel/framework/issues/30879#issuecomment-567456608)

Unit tests were recently updated to make use of the PHPUnit TestCase class so the framework isn't booted (hence why factories aren't available). This was done because in general, you want your unit tests to run as fast as possible. Objects in your unit tests are usually tested in isolation without any outside dependencies.

If you need a factory consider placing your test in the Feature directory. 