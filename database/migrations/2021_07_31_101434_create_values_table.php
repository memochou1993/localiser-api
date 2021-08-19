<?php

use App\Models\Key;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->foreignIdFor(Project::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Key::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Language::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('values');
    }
}
