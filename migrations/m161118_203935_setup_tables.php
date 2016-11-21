<?php

use yii\db\Migration;

class m161118_203935_setup_tables extends Migration
{
    public function up()
    {
    	if (!$this->getDb()->createCommand('SHOW TABLES LIKE "user"')->queryScalar()) {
			$this->createTable('user', array(
				'id' => 'BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT',
				'type' => 'INT(1) UNSIGNED NULL',
				'status' => 'INT(1) UNSIGNED NULL',
				'name' => 'VARCHAR(255) NOT NULL',
				'email' => 'VARCHAR(255) NOT NULL',
				'password' => 'VARCHAR(60) NOT NULL',
				'created_at' => 'DATETIME NULL',
				'updated_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
				'PRIMARY KEY (id)',
				'UNIQUE INDEX `uk_user_1` (`email` ASC)',
			), 'ENGINE = InnoDB');
		
			$this->createTable('article', array(
				'id' => 'BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT',
				'id_user' => 'BIGINT(21) UNSIGNED NOT NULL',
				'title' => 'VARCHAR(255) NOT NULL',
				'text' => 'LONGTEXT NOT NULL',
				'excerpt' => 'VARCHAR(255) NULL',
				'picture' => 'TEXT NOT NULL',
				'status' => 'INT(1) UNSIGNED DEFAULT 0',
				'created_at' => 'DATETIME NULL',
				'updated_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
				'published_at' => 'DATETIME NULL',
				'PRIMARY KEY (`id`)',
			  'INDEX `fk_article_user_idx` (`id_user` ASC)',
			), 'ENGINE = InnoDB');
			
			$this->addForeignKey('fk_article_user', 'article', 'id_user', 'user', 'id');
    	}
		
		$this->insert('user', array(
			'type' => app\models\User::TYPE_ADMIN,
			'status' => app\models\User::STATUS_ENABLED,
			'name' => 'Admin',
			'email' => 'admin@newsportal.com',
			'password' => app\models\User::hashPassword('admin'),
			'created_at' => new \yii\db\Expression('NOW()'),
		));
    }

    public function down()
    {
        if ($this->getDb()->schema->getTableSchema('article'))
        	$this->dropTable('article');
        if ($this->getDb()->schema->getTableSchema('user'))
	        $this->dropTable('user');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
