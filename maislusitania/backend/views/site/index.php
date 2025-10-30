<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <!-- Info Boxes Row -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Locais Culturais',
                'number' => '25',
                'icon' => 'fas fa-landmark',
                'theme' => 'info',
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Eventos Ativos',
                'number' => '18',
                'icon' => 'fas fa-calendar-alt',
                'theme' => 'success',
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Utilizadores',
                'number' => '342',
                'icon' => 'fas fa-users',
                'theme' => 'warning',
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Reservas (Mês)',
                'number' => '127',
                'icon' => 'fas fa-ticket-alt',
                'theme' => 'danger',
            ]) ?>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <!-- Latest Reservations -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-check"></i> Últimas Reservas</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-eye"></i> Ver Todas
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Evento</th>
                                <th>Utilizador</th>
                                <th>Data</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Exposição de Arte</td>
                                <td>João Silva</td>
                                <td>28/10/2025</td>
                                <td><span class="badge badge-success">Confirmada</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Concerto de Fado</td>
                                <td>Maria Santos</td>
                                <td>27/10/2025</td>
                                <td><span class="badge badge-warning">Pendente</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Peça de Teatro</td>
                                <td>Pedro Costa</td>
                                <td>26/10/2025</td>
                                <td><span class="badge badge-success">Confirmada</span></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Workshop Digital</td>
                                <td>Ana Ferreira</td>
                                <td>25/10/2025</td>
                                <td><span class="badge badge-danger">Cancelada</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Reviews -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star"></i> Últimas Avaliações</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-eye"></i> Ver Todas
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Local</th>
                                <th>Utilizador</th>
                                <th>Rating</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Museu Nacional</td>
                                <td>Carlos M.</td>
                                <td>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </td>
                                <td>28/10/2025</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Teatro Nacional</td>
                                <td>Sofia L.</td>
                                <td>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </td>
                                <td>27/10/2025</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Casa da Música</td>
                                <td>Rui P.</td>
                                <td>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </td>
                                <td>26/10/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar"></i> Vendas - Últimos 6 Meses</h3>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro'],
            datasets: [{
                label: 'Lucro (€)',
                data: [3200, 4500, 6000, 5200, 4800, 6500],
                backgroundColor: '#5cb85c',
                borderColor: '#4cae4c',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '€' + value;
                        }
                    }
                }
            }
        }
    });
");