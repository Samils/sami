/**
 * -----------------
 * @package Sami\Base
 * - Draw data base table structure
 * - accordig to what is defined inside
 * - the migration (change or up) method
 */
namespace Sami\Base {
  /**
   * @Migration '<?= $props ['className'] ?>'
   * Draw Base
   */
  class <?= $props ['className'] ?> extends Migration {
    function up () {
    }

    function down () {
    }
  }
}
