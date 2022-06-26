<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateClientPackageViewTable extends Migration
{
    public function up()
    {
        DB::statement($this->createView());
    }

    public function down()
    {
        DB::statement("DROP VIEW client_package_view");
    }

    private function createView(): string
    {
        return <<<SQL
                CREATE OR REPLACE VIEW  client_package_view  AS
                SELECT q1.id , q1.name ,palatinum_discount , basic_discount , golden_discount  FROM
                (SELECT package_discount as palatinum_discount ,users.fullname as name,users.id AS id  FROM client_package JOIN users ON users.id = client_package.client_id JOIN packages
                 ON packages.id = client_package.package_id
                JOIN package_translations ON package_translations.package_id = packages.id WHERE package_translations.name = 'Platinum' ) as q1
                JOIN
                (SELECT package_discount as basic_discount ,users.id AS id  FROM client_package JOIN users ON users.id = client_package.client_id JOIN packages ON packages.id = client_package.package_id
                JOIN package_translations ON package_translations.package_id = packages.id WHERE package_translations.name = 'Basic' ) as q2
                ON q1.id = q2.id
                JOIN
                (SELECT package_discount as golden_discount ,users.id AS id  FROM client_package JOIN users ON users.id = client_package.client_id JOIN packages ON packages.id = client_package.package_id
                JOIN package_translations ON package_translations.package_id = packages.id WHERE package_translations.name = 'Gold' ) AS q3
                ON q2.id = q3.id
            SQL;
    }
}
