class SomeClass
{
    private $name;
    private $dm;

    public function __construct(DocumentManager $dm = null)
    {
        $this->dm = $dm;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}
