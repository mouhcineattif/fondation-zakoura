<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('code_projet')->unique();

            $table->enum('nature_du_projet', ['Opérationnel', 'Institutionnel', 'Expérimental']);


            $table->enum('type_du_projet', ['Alphabétisation', 'Éducation', 'Formation', 'Sensibilisation']);

            $table->enum('type_du_partenaire', ['Opérationnel', 'Institutionnel', 'Expérimental']);


            $table->enum('structure_du_partenaire', ['Publique', 'Privée', 'Associative', 'Coopérative']);


            $table->enum('statut_du_projet', ['Prospection', 'En discussion', 'Convention signée', 'Contrat actif', 'Archivé']);

            $table->date('date_de_lancement');

            $table->date('date_de_cloture')->nullable();

            $table->date('date_de_debut_reelle')->nullable();

            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('restrict');

            // Partenaire(s) et Rôle du partenaire
            // Je pense que c'est mieux creer une table pivot (partenaire_projects) avec les colonnes suivantes :
            // - partenaire_id
            // - projet_id
            // - role_du_partenaire

            $table->decimal('budget_total', 15, 2);

            $table->decimal('quote_part_partenaire', 15, 2)->nullable();

            $table->decimal('apport_fz_zakoura', 15, 2)->nullable();

            $table->enum('banque', ['BMCE', 'CIH', 'BOA', 'Attijari']);

            $table->string('agence_bancaire');

            $table->string('rib', 34);

            $table->text('notes_ou_observation')->nullable();


            $table->unsignedBigInteger('created_by_user_id');
            $table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

