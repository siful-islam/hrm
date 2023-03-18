<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblPermanent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('tbl_permanent', function (Blueprint $table) {
			$table->integer('id');
			$table->integer('emp_id');
			$table->integer('sarok_no');
			$table->date('letter_date');
			$table->date('effect_date');
			$table->tinyInteger('designation_code');
			$table->tinyInteger('br_code');
			$table->tinyInteger('grade_code');
			$table->tinyInteger('grade_step');
			$table->tinyInteger('department_code');
			$table->tinyInteger('report_to');
			$table->date('next_increment_date');
			$table->integer('org_code');
			$table->tinyInteger('status');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_permanent');
    }
}
