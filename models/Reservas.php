<?php

namespace app\models;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $vuelo_id
 * @property string $asiento
 * @property string $fecha_hora
 * @property Usuarios $usuario
 * @property Vuelos $vuelo
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'vuelo_id', 'asiento'], 'required'],
            [['usuario_id', 'vuelo_id'], 'default', 'value' => null],
            [['usuario_id', 'vuelo_id'], 'integer'],
            [['asiento'], 'number'],

            // Valida si un asiento para cada vuelo es único
            [['vuelo_id', 'asiento'],
                'unique',
                'targetAttribute' => ['vuelo_id', 'asiento'],
                'message' => 'El asiento elegido no está disponible',
            ],

            // El usuario_id tiene que coincidir
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],

            [['vuelo_id'], 'exist'],

            // Compruebo que para un vuelo existan plazas libres
            [['vuelo_id'], function ($attribute) {
                $vuelo = Vuelos::findOne($this->$attribute);
                if (!$vuelo->tieneplazaslibres) {
                    $this->addError($attribute, 'Sin plazas libres.');
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'vuelo_id' => 'Vuelo ID',
            'asiento' => 'Asiento',
            'fecha_hora' => 'Fecha y Hora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('reservas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelo()
    {
        return $this->hasOne(Vuelos::className(), ['id' => 'vuelo_id'])->inverseOf('reservas');
    }
}
