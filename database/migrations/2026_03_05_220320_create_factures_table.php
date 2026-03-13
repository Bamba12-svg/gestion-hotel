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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_chambre', 8, 2);
            $table->decimal('montant_services', 8, 2)->default(0);
            $table->decimal('montant_total', 8, 2);
            $table->enum('statut_paiement', ['non_paye', 'paye', 'partiel'])->default('non_paye');
            $table->enum('mode_paiement', ['especes', 'carte', 'virement'])->nullable();
            $table->timestamp('date_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
