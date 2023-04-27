namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('expenses.index', ['expenses' => $expenses]);
    }

    public function create()
    {
        //Loading create view page from controller
        return view('expenses.create');
    }

    public function store(ExpenseRequest $request)
    {
        //adding data using Eloquent ORM method

        $expense = Expense::create($request->all());
        return redirect('/expenses')->with('success', 'Expense saved!'); //Returning to expenses list view with expense added message
    }

    public function edit($id)
    {
        //fatching data edit view page using Eloquent ORM method

        $expense = Expense::findOrFail($id);
        return view('expenses.edit', ['expense' => $expense]); //Returning to Perticular edit page view to edit data
    }

    public function update(ExpenseRequest $request, $id)
    {
        //Updating data in database using Eloquent ORM method

        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return redirect('/expenses')->with('success', 'Expense updated!');  //Returning to expenses list view with data updated message
    }

    public function destroy($id)
    {
        //Deleting record from database after fatching data by ID

        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect('/expenses')->with('success', 'Expense deleted!');  //Returning to expenses list view with Expense deleted message
    }
}

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Expense;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Expense::$rules;
    }
}

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['name', 'amount', 'date'];
    
    public static $rules = [
        'name' => 'required|max:255',
        'amount' => 'required|numeric',
        'date' => 'required|date',
    ];
}
