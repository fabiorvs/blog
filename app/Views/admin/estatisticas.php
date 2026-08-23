<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<?php
$periods = ['today' => 'Hoje', '7days' => '7 dias', '30days' => '30 dias', 'month' => 'Este mês', '12months' => '12 meses'];
$average = $uniqueVisitors > 0 ? $totalVisits / $uniqueVisitors : 0;
$panels = [
    ['Dispositivos', $devices, 'nome', 'Como seu público acessa o site'],
    ['Navegadores', $browsers, 'nome', 'Tecnologias utilizadas nas visitas'],
    ['Países', $countries, 'nome', 'Localização aproximada dos acessos'],
    ['Páginas mais acessadas', $pages, 'nome', 'Conteúdos com maior audiência'],
    ['Origens do tráfego', $referrers, 'nome', 'De onde os visitantes chegaram'],
];
?>

<div class="admin-page-header analytics-header">
    <div>
        <span class="analytics-eyebrow">Audiência</span>
        <h1>Estatísticas</h1>
        <p><?= esc($periodLabel) ?> · dados desde <?= esc($start) ?></p>
    </div>
    <nav class="analytics-periods" aria-label="Período das estatísticas">
        <?php foreach ($periods as $key => $label) : ?>
            <a class="<?= $period === $key ? 'active' : '' ?>" href="<?= base_url('admin/estatisticas?period=' . $key) ?>"><?= esc($label) ?></a>
        <?php endforeach ?>
    </nav>
</div>

<div class="analytics-summary">
    <article class="analytics-metric analytics-metric--primary">
        <span class="analytics-metric__icon"><svg class="admin-icon"><use href="#icon-chart"/></svg></span>
        <div><strong><?= number_format($totalVisits, 0, ',', '.') ?></strong><span>Visualizações</span></div>
        <small>Total no período</small>
    </article>
    <article class="analytics-metric">
        <span class="analytics-metric__icon"><svg class="admin-icon"><use href="#icon-users"/></svg></span>
        <div><strong><?= number_format($uniqueVisitors, 0, ',', '.') ?></strong><span>Visitantes únicos</span></div>
        <small>Pessoas estimadas</small>
    </article>
    <article class="analytics-metric">
        <span class="analytics-metric__icon analytics-metric__icon--accent">×</span>
        <div><strong><?= number_format($average, 1, ',', '.') ?></strong><span>Páginas por visitante</span></div>
        <small>Média no período</small>
    </article>
</div>

<section class="admin-card analytics-card analytics-card--timeline">
    <div class="analytics-card__header">
        <div><h2><?= esc($timelineLabel) ?></h2><p>Evolução dos acessos no período selecionado</p></div>
        <span class="analytics-card__total"><?= number_format($totalVisits, 0, ',', '.') ?> acessos</span>
    </div>
    <div class="analytics-chart">
        <?php $dailyMax = max(array_column($daily, 'total') ?: [1]); ?>
        <?php foreach ($daily as $row) : ?>
            <div class="analytics-chart__item">
                <span class="analytics-chart__label"><?= esc($row['dia']) ?></span>
                <div class="analytics-chart__track"><i style="width: <?= max(2, round($row['total'] / $dailyMax * 100, 1)) ?>%"></i></div>
                <strong><?= number_format($row['total'], 0, ',', '.') ?></strong>
            </div>
        <?php endforeach ?>
        <?php if (! $daily) : ?><div class="analytics-empty">Ainda não há acessos neste período.</div><?php endif ?>
    </div>
</section>

<div class="analytics-grid">
    <?php foreach ($panels as [$title, $rows, $field, $description]) : ?>
        <section class="admin-card analytics-card">
            <div class="analytics-card__header"><div><h2><?= esc($title) ?></h2><p><?= esc($description) ?></p></div></div>
            <div class="analytics-list">
                <?php $max = max(array_column($rows, 'total') ?: [1]); ?>
                <?php foreach ($rows as $row) : ?>
                    <div class="analytics-row">
                        <div class="analytics-row__info"><span title="<?= esc($row[$field]) ?>"><?= esc($row[$field]) ?></span><strong><?= number_format($row['total'], 0, ',', '.') ?></strong></div>
                        <div class="analytics-row__track"><i style="width: <?= max(2, round($row['total'] / $max * 100, 1)) ?>%"></i></div>
                    </div>
                <?php endforeach ?>
                <?php if (! $rows) : ?><div class="analytics-empty">Ainda não há dados neste período.</div><?php endif ?>
            </div>
        </section>
    <?php endforeach ?>
</div>
<?= $this->endSection() ?>
