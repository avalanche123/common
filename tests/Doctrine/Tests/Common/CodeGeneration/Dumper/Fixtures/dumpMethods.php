private static function dumpMethods(array $methods = array())
{
    foreach ($methods as $name => $method) {
        $this->dumpMethod($name, $method);
    }
}
