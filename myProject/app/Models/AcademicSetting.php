namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSetting extends Model
{
    protected $table = 'academic_settings';
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'current_quarter',
        'current_week',
        'school_year',
        'updated_by'
    ];

    protected $casts = [
        'current_week' => 'integer'
    ];

    // Uncomment if your table has no timestamps
    // public $timestamps = false;
}
