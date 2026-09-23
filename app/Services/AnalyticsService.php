<?php
namespace App\Services;
class AnalyticsService
{
    private $db;
    public function __construct() { $this->db = db_connect(); }
    public function report(string $period): array
    {
        if (! in_array($period, ['today', '7days', '30days', 'month', '12months'], true)) {
            $period = '30days';
        }

        [$start,$label]=$this->range($period); $where=['visited_at >='=>$start->format('Y-m-d H:i:s'), 'navegador !='=>'Outro'];
        $totals=$this->db->table('visitas')->select('COUNT(*) visits, COUNT(DISTINCT visitante_hash) visitors',false)->where($where)->get()->getRowArray();
        $monthly=$period==='12months';
        return ['period'=>$period,'periodLabel'=>$label,'start'=>$start->format('d/m/Y'),'totalVisits'=>(int)($totals['visits']??0),'uniqueVisitors'=>(int)($totals['visitors']??0),'timelineLabel'=>$monthly?'Visitas por mês':'Visitas por dia','daily'=>$this->timeline($monthly?"DATE_FORMAT(visited_at, '%Y-%m')":'DATE(visited_at)',$where),'browsers'=>$this->group('navegador','nome',$where,8),'devices'=>$this->group('dispositivo','nome',$where,8),'countries'=>$this->countries($where),'pages'=>$this->group('caminho','nome',$where,10),'referrers'=>$this->group("COALESCE(referencia, 'Direto')",'nome',$where,10)];
    }
    private function group(string $field,string $alias,array $where,int $limit): array { return $this->db->table('visitas')->select("$field AS $alias, COUNT(*) AS total",false)->where($where)->groupBy($field,false)->orderBy('total','DESC')->limit($limit)->get()->getResultArray(); }
    private function timeline(string $field,array $where): array { return $this->db->table('visitas')->select("$field AS dia, COUNT(*) AS total",false)->where($where)->groupBy($field,false)->orderBy('dia','ASC')->get()->getResultArray(); }
    private function countries(array $where): array { $rows=$this->group("COALESCE(pais, 'XX')",'codigo',$where,15); foreach($rows as &$row)$row['nome']=$row['codigo']==='XX'?'Não identificado':(class_exists('Locale')?\Locale::getDisplayRegion('-'.$row['codigo'],'pt_BR'):$row['codigo']); return $rows; }
    private function range(string $period): array { $today=new \DateTimeImmutable('today');$ranges=['today'=>[$today,'Hoje'],'7days'=>[$today->modify('-6 days'),'Últimos 7 dias'],'30days'=>[$today->modify('-29 days'),'Últimos 30 dias'],'month'=>[$today->modify('first day of this month'),'Este mês'],'12months'=>[$today->modify('-1 year'),'Últimos 12 meses']];return $ranges[$period]??$ranges['30days']; }
}
