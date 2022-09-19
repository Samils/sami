namespace Sami\Base {
  use Product;

  class <?= $props ['name'] ?> extends Procedure {
    protected $fluxState;

    public function initialize () {
      $this->fluxState = new FluxState (
        // [ 'datas' => [] ]
      );
    }

    function handle () {
      // Handler...
    }
  }
}
