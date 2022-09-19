/**
 * <?= $props ['className'] ?>
 * -
 * Controller that'll manage
 * the application basic requests
 */
class <?= $props ['className'] ?> extends SamiController {
  <?php if (is_array ($props ['methods'])) {
    foreach ($props ['methods'] as $method) { ?>

  /**
   * @method void <?= $method ?>

   */
  function <?= $method ?> () {}
  <?php }} ?>

}
