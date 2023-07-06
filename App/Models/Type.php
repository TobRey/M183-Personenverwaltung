<?php

namespace App\Models;

use App\Gateways\TypeGateway;
use JsonSerializable;

class Type implements JsonSerializable
{
    private int $id = 0;
    private string $label;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public static function all(): array
    {
        $gateway = new TypeGateway();
        $types = [];

        $tmpTypes = $gateway->all();

        if ($tmpTypes) {
            while ($tmpType = $tmpTypes->fetch_assoc()) {
                $type = new Type();
                $type->id = $tmpType['id'];
                $type->label = $tmpType['label'];

                $types[] = $type;
            }
        }

        return $types;
    }

    public static function findById(int $id): ?Type
    {
        $gateway = new TypeGateway();

        $tmpType = $gateway->findById($id);

        $type = null;

        if ($tmpType) {
            $type = new Type();
            $type->id = $tmpType['id'];
            $type->label = $tmpType['label'];
        }

        return $type;
    }

    public function save()
    {
        $gateway = new TypeGateway();

        if (!$this->id) {
            $this->id = $gateway->insert([
                'label' => $this->label,
            ]);
        } else {
            $gateway->update($this->id, [
                'label' => $this->label,
            ]);
        }
    }

    public function delete()
    {
        $gateway = new TypeGateway();
        $gateway->delete($this->id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
        ];
    }
}
