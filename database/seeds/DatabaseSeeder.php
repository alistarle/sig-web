<?php

use App\Models\Area;
use App\Models\Hunt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Phaza\LaravelPostgis\Geometries\Point;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Setup hunt seeder
         */

        $hunt = new Hunt();
        $hunt->name = "Chasse 1";
        $hunt->treasure = new Point(1.934370,47.844170);
        $hunt->save();

        $hunt2 = new Hunt();
        $hunt2->name = "Chasse 2";
        $hunt2->treasure = new Point(1.926340,47.844170);
        $hunt2->save();

        /**
         * Setup Area seeder
         */

        $area = new Area();
        $area->name = "Etape 1";
        $area->center = new Point(1.934370,47.844170);
        $area->radius = 0.00650;
        $area->order = 1;
        $hunt->steps()->save($area);

        $area = new Area();
        $area->name = "Etape 2";
        $area->center = new Point(1.934370,47.844170);
        $area->radius = 0.00300;
        $area->order = 2;
        $hunt->steps()->save($area);

        $area = new Area();
        $area->name = "Etape 3";
        $area->center = new Point(1.934370,47.844170);
        $area->radius = 0.00150;
        $area->order = 3;
        $hunt->steps()->save($area);


        $area = new Area();
        $area->name = "Etape 1";
        $area->center = new Point(1.926340,47.844170);
        $area->radius = 0.00650;
        $area->order = 1;
        $hunt2->steps()->save($area);

        $area = new Area();
        $area->name = "Etape 2";
        $area->center = new Point(1.926340,47.844170);
        $area->radius = 0.00350;
        $area->order = 2;
        $hunt2->steps()->save($area);
    }
}
