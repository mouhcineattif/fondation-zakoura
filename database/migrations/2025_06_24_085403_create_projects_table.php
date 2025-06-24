<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Informations générales
            $table->string('nom_projet'); // Texte court obligatoire
            $table->string('code_projet'); // Texte court obligatoire
            $table->enum('nature_projet', ['Opérationnel', 'Institutionnel', 'Expérimental'])->nullable(false);
            $table->enum('type_projet', ['Alphabétisation', 'Éducation', 'Formation', 'Sensibilisation'])->nullable(false);

            // Dates du projet
            $table->enum('statut_projet', ['Initiation', 'Conception', 'En cours', 'Terminé', 'Archivé']);
            $table->date('date_lancement');
            $table->date('date_cloture');
            $table->date('date_debut_reelle')->nullable();

            // Responsabilités
            $table->unsignedBigInteger('responsable_id'); // utilisateur SI
            $table->json('partenaires'); // multiple IDs
            $table->enum('role_partenaire', ['Principal', 'Co-porteur', 'Financier', 'Appui technique']);

            // Budget
            $table->decimal('budget_total', 15, 2); // en MAD ou devise liée
            $table->decimal('quote_part_partenaires', 15, 2)->nullable();
            $table->decimal('apport_fz', 15, 2)->nullable();

            // Infos bancaires
            $table->string('banque'); // BMCE, CIH, BOA...
            $table->string('agence_bancaire')->nullable();
            $table->string('rib');

            // Notes / Références / Générés automatiquement
            $table->text('notes')->nullable();
            $table->string('code_automatique')->nullable()->unique();
            $table->timestamps();

            // Foreign key (si users table existe)
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
