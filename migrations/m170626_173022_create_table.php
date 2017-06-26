<?php

use yii\db\Migration;

class m170626_173022_create_table extends Migration
{
    public function up()
    {
        $this->createTable('table', [
            'id' => $this->primaryKey(),
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'phoneNumber' => $this->string()->notNull(),
            'birthday' => $this->date(),
            'text' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('table');
    }


}
