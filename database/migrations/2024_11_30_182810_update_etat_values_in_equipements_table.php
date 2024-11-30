<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('equipements', function (Blueprint $table) {
            // Met à jour l'ENUM pour inclure les nouvelles valeurs
            $table->enum('etat', ['attribué', 'en attente de récupération', 'récupéré', 'en stock', 'en attente'])
                ->default('en stock')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('equipements', function (Blueprint $table) {
            // Revenir à l'ancienne définition
            $table->enum('etat', ['attribué', 'en attente de récupération', 'récupéré'])
                ->default('attribué')
                ->change();
        });
    }
};
