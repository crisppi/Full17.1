<?php

class gestao
{
  public $id_gestao;
  public $gestao_aco;
  public $valor_aco;
  public $fk_hospital;
  public $data_create;
  public $usuario_create;
}
interface gestaoDAOInterface
{

  public function buildgestao($gestao);
  public function findAll();
  public function getgestao();
  public function findById($id_gestao);
  public function findByIdUpdate($id_gestao);
  public function create(gestao $gestao);
  public function update($gestao);
  public function destroy($id_gestao);
  public function joingestaoHospital();
  public function joingestaoHospitalShow($id_gestao);
  public function findGeral();
};
