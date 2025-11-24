<?php
    
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
    use DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\View\View;
    use Illuminate\Http\RedirectResponse;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    
    class RoleController extends Controller
    {
        use ValidatesRequests;

    
        /**
         * RoleController constructor.
         */
        public function __construct()
        {
            $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
            $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
            $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {

         $roles = Role::all();
        $roles = Role::paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function searches(Request $request){
        $searches=$request->search;
        $roles=Role::where(function($query) use ($searches){
            $query->where('name','like',"%$searches%");
        })->paginate(5);
       
       return view('roles.index',compact('roles','searches'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        
        // Sync permissions by name
        $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name');
        $role->syncPermissions($permissions);
    
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array',
        ]);
    
        $role = Role::find($id);
    
        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error', 'Role not found!');
        }
    
        $role->name = $request->input('name');
        $role->save();
    
        // Sync permissions by name
        $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name');
        $role->syncPermissions($permissions);
    
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully!');
    }
    
    
    
   
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}