<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        $tableList = $this->getTableList('sample');
        foreach ($tableList as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->char('id', 26);
                $table->string('field', 150);
                $table->dateTime('created');
                $table->dateTime('modified');
                $table->dateTime('deleted')
                    ->nullable()
                    ->default(null);
                $table->primary('id');
                $table->index('field');
                $table->index('created');
                $table->index('modified');
                $table->index('deleted');
            });
        }
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        $tableList = $this->getTableList('sample');
        foreach ($tableList as $tableName) {
            Schema::dropIfExists($tableName);
        }
    }

    /**
     * Get table name depends on environment.
     * @return string $table
     * @return string
     */
    public function getTestOrNot(
        string $table
    ) {
        $environment = env('APP_ENV', 'local');
        if ($environment == 'testing-feature') {
            $table .= '_test';
        }
        return $table;
    }

    /**
     * Get table list.
     * @param string $table
     * @return array
     */
    public function getTableList(
        string $table
    ) {
        $list = env('DB_SUFFIX_LIST', '');
        $environment = env('APP_ENV', 'local');
        $useSuffix = env('DB_USE_SUFFIX', false);

        $table = $this->getTestOrNot($table);
        $tablesList = [
            $table
        ];

        if (!$useSuffix) {
            return $tablesList;
        }

        if (
            !empty($list) &&
            $environment != 'testing-feature'
        ) {
            $suffixList = explode(',', $list);

            $tablesList = [];
            foreach ($suffixList as $suffix) {
                $tablesList[] = $table . $suffix;
            }
        }

        return $tablesList;
    }
}
