<?php

namespace app\models;
use function array_combine;
use function array_diff;
use function var_dump;

/**
 * This is the model class for table "vuelos".
 *
 * @property int $id
 * @property string $codigo
 * @property int $origen_id
 * @property int $destino_id
 * @property int $compania_id
 * @property string $salida
 * @property string $llegada
 * @property string $plazas
 * @property string $precio
 *
 * @property Reservas[] $reservas
 * @property Aeropuertos $origen
 * @property Aeropuertos $destino
 * @property Companias $compania
 */
class Vuelos extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vuelos';
    }

    /**
     * @var $libres Contiene las plazas libres del modelo
     */
    public $libres;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['origen_id', 'destino_id', 'compania_id', 'salida', 'llegada', 'plazas', 'precio'], 'required'],
            [['origen_id', 'destino_id', 'compania_id'], 'default', 'value' => null],
            [['origen_id', 'destino_id', 'compania_id'], 'integer'],
            [['salida', 'llegada'], 'safe'],
            [['plazas', 'precio'], 'number'],
            [['codigo'], 'string'],
            [['codigo'], 'unique'],

            // Tiene que haber origen
            [['origen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['origen_id' => 'id']],

            // Tiene que haber destino
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['destino_id' => 'id']],

            // Tiene que haber Compa
            [['compania_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companias::className(), 'targetAttribute' => ['compania_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'origen_id' => 'Origen ID',
            'destino_id' => 'Destino ID',
            'compania_id' => 'Compañía ID',
            'salida' => 'Salida',
            'llegada' => 'Llegada',
            'plazas' => 'Plazas',
            'precio' => 'Precio',
        ];
    }

    /**
     * Devuelve un booleano que indica si existe plaza libre
     * @return Boolean Será true si hay plaza libre.
     */
    public function getTienePlazasLibres()
    {
        return $this->getPlazasLibres() != 0;
    }

    /**
     * Devuelve la cantidad de plazas disponibles
     * @return int|string Valor con la cantidad de plazas
     */
    public function getPlazasLibres()
    {
        $total = $this->plazas - $this->getReservas()->count();
        return $total;
    }

    /**
     * Devuelve un Array con las plazas que aún están libres
     */
    public static function listaPlazasLibres($vuelo_id) {
        $vuelo = Vuelos::find()->where(['id' => $vuelo_id]);
        $reservas = Reservas::find()->where(['vuelo_id' => $vuelo_id]);

        $plazasTotales = $vuelo->select('plazas')->scalar();  // plazas
        $plazasReservadas = $reservas->select('asiento')->column(); // reservas

        $plazaslibres = array_diff(range(1, $plazasTotales), $plazasReservadas);

        // Combina creando parejas de index => value
        return array_combine($plazaslibres, $plazaslibres);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::className(), ['vuelo_id' => 'id'])->inverseOf('vuelo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigen()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'origen_id'])->inverseOf('vuelos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestino()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'destino_id'])->inverseOf('vuelos0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompania()
    {
        return $this->hasOne(Companias::className(), ['id' => 'compania_id'])->inverseOf('vuelos');
    }
}
