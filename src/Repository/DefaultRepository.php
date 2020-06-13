<?php
declare(strict_types=1);

namespace SONFin\Repository;

use Psr\Http\Message\RequestInterface;
use Illuminate\Database\Eloquent\Model;

class DefaultRepository implements RepositoryInterface
{
    // var string
    private $modelClass;

    // var Model
    private $model;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
        // Instanciando a classe
        $this->model = new $modelClass;
    }

    public function all()
    {
        return $this->model->all()->toArray();
    }

    public function find(int $id, bool $failIfNotExist = true)
    {
        // Busca ternária se não existir ele lançará exceção, se não ele buscará o id em model
        return $failIfNotExist?$this->model->findOrFail($id):
            $this->model->find($id);
    }

    public function create(array $data)
    {
        $this->model->fill($data);
        $this->model->save();
        return $this->model;
    }

    public function update($id, array $data)
    {
        $model = $this->findInternal($id);
        $model->fill($data);
        $model->save();
        return $model;
    }
    public function delete($id)
    {
        $model = $this->findInternal($id);
        $model->delete();
    }

    protected function findInternal($id)
    {
        return is_array($id) ? $model = $this->findOneBy($id) : $this->find($id);
    }

    public function findByField(string $field, $value)
    {
        return $this->model->where($field, '=', $value)->get();
    }

    public function findOneBy(array $search)
    {
        $queryBuilder = $this->model;

        foreach ($search as $field => $value) {
            $queryBuilder = $queryBuilder->where($field, '=', $value);
        }
        return $queryBuilder->firstOrFail();
    }
}
