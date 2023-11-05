<?php
	
	namespace Database\Seeders;
	
	// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	
	use App\Models\User;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\Hash;
	use Spatie\Permission\Models\Permission;
	use Spatie\Permission\Models\Role;
	
	class PermissionTabelSeeder extends Seeder
	{
		
		/**
		 * List of applications to add.
		 */
		private $permissions = [
			'الفواتير',
			'قائمة الفواتير',
			'الفواتير المدفوعة',
			'الفواتير المدفوعة جزئيا',
			'الفواتير الغير مدفوعة',
			'ارشيف الفواتير',
			'التقارير',
			'تقرير الفواتير',
			'تقرير العملاء',
			'المستخدمين',
			'قائمة المستخدمين',
			'صلاحيات المستخدمين',
			'الاعدادات',
			'المنتجات',
			'الاقسام',
			
			
			'اضافة فاتورة',
			'حذف الفاتورة',
			'تصدير EXCEL',
			'تغير حالة الدفع',
			'تعديل الفاتورة',
			'ارشفة الفاتورة',
			'طباعةالفاتورة',
			'اضافة مرفق',
			'حذف المرفق',
			
			'اضافة مستخدم',
			'تعديل مستخدم',
			'حذف مستخدم',
			
			'عرض صلاحية',
			'اضافة صلاحية',
			'تعديل صلاحية',
			'حذف صلاحية',
			
			'اضافة منتج',
			'تعديل منتج',
			'حذف منتج',
			
			'اضافة قسم',
			'تعديل قسم',
			'حذف قسم',
			'الاشعارات',
		];
		
		
		/**
		 * Seed the application's database.
		 */
		public function run(): void
		{
			foreach ($this->permissions as $permission) {
				Permission::create(['name' => $permission]);
			}
			
			
		}
	}
