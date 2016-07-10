<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

use yii\db\Migration;

class m160710_100350_init extends Migration
{
    public function up()
    {
        $this->createTable('holiday_name', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull()->unique(),
        ]);
        $this->execute(sprintf(
            'CREATE TABLE {{holiday}} ( %s )',
            implode(', ', [
                '[[date]] INTEGER NOT NULL PRIMARY KEY', // YYYYMMDD
                '[[name_id]] INTEGER NOT NULL',
                'FOREIGN KEY ([[name_id]]) REFERENCES {{holiday_name}}([[id]])',
            ])
        ));
    }

    public function down()
    {
        $this->dropTable('holiday');
        $this->dropTable('holiday_name');
    }
}
