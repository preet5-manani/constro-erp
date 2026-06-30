<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Booking;
use App\Models\Contractor;
use App\Models\ContractorPayment;
use App\Models\ContractorTask;
use App\Models\Customer;
use App\Models\Flat;
use App\Models\Floor;
use App\Models\Installment;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SiteVisit;
use App\Models\Task;
use App\Models\TaskDependency;
use App\Models\Tower;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MockDataSeeder extends Seeder
{
    /**
     * Generate demo data for every module.
     *
     * Run with: php artisan db:seed --class=MockDataSeeder
     */
    public function run(): void
    {
        // Skip auditing/observers for bulk demo data so the audit log stays clean.
        Model::withoutEvents(function () {
            $faker = fake();

            $this->command?->info('Seeding users...');
            $managerRole = Role::where('name', 'Manager')->first();
            for ($i = 0; $i < 6; $i++) {
                $user = User::firstOrCreate(
                    ['email' => $faker->unique()->safeEmail()],
                    ['name' => $faker->name(), 'password' => Hash::make('password')]
                );
                if ($managerRole) {
                    $user->assignRole($managerRole);
                }
            }
            $userIds = User::pluck('id')->all();

            $this->command?->info('Seeding customers...');
            $customers = collect(range(1, 18))->map(fn () => Customer::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->numerify('+91 9#########'),
                'address' => $faker->address(),
            ]));

            $this->command?->info('Seeding projects, towers, floors and flats...');
            $statuses = ['planning', 'active', 'completed', 'on_hold'];
            $availableFlats = collect();
            $allTasks = collect();

            foreach (['Skyline Residency', 'Green Valley Heights', 'Lakeview Enclave'] as $idx => $projectName) {
                $project = Project::create([
                    'name' => $projectName,
                    'location' => $faker->city(),
                    'start_date' => Carbon::now()->subMonths(rand(3, 12)),
                    'end_date' => Carbon::now()->addMonths(rand(6, 24)),
                    'status' => $statuses[$idx % count($statuses)],
                    'budget' => $faker->numberBetween(50, 500) * 100000,
                ]);

                foreach (range(1, rand(2, 3)) as $t) {
                    $tower = Tower::create([
                        'project_id' => $project->id,
                        'name' => 'Tower ' . chr(64 + $t),
                    ]);

                    foreach (range(1, rand(3, 5)) as $floorNumber) {
                        $floor = Floor::create([
                            'tower_id' => $tower->id,
                            'floor_number' => $floorNumber,
                        ]);

                        foreach (range(1, rand(4, 6)) as $unit) {
                            $status = $faker->randomElement(['available', 'available', 'available', 'reserved', 'booked', 'sold']);
                            $flat = Flat::create([
                                'floor_id' => $floor->id,
                                'flat_number' => $floorNumber . sprintf('%02d', $unit),
                                'area' => $faker->numberBetween(550, 2200),
                                'price' => $faker->numberBetween(25, 120) * 100000,
                                'status' => $status,
                            ]);

                            if ($status === 'available') {
                                $availableFlats->push($flat);
                            }
                        }
                    }
                }

                // Tasks + dependencies per project
                $projectTasks = collect();
                $taskNames = ['Site Preparation', 'Foundation', 'Structure', 'Plumbing', 'Electrical', 'Finishing', 'Handover'];
                foreach ($taskNames as $tIndex => $taskName) {
                    $start = Carbon::now()->subMonths(6)->addWeeks($tIndex * 3);
                    $task = Task::create([
                        'project_id' => $project->id,
                        'parent_id' => null,
                        'name' => $taskName,
                        'type' => $tIndex === count($taskNames) - 1 ? 'milestone' : 'task',
                        'start_date' => $start,
                        'end_date' => (clone $start)->addWeeks(rand(2, 4)),
                        'progress' => rand(0, 100),
                        'assigned_to' => $faker->randomElement($userIds),
                        'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                    ]);

                    // Each task depends on the previous one
                    if ($projectTasks->isNotEmpty()) {
                        TaskDependency::create([
                            'task_id' => $task->id,
                            'depends_on_task_id' => $projectTasks->last()->id,
                        ]);
                    }

                    $projectTasks->push($task);
                    $allTasks->push($task);
                }
            }

            $this->command?->info('Seeding vendors and purchase orders...');
            $vendors = collect(range(1, 6))->map(fn () => Vendor::create([
                'name' => $faker->company(),
                'contact' => $faker->numerify('+91 9#########'),
                'address' => $faker->address(),
                'gst_number' => strtoupper($faker->bothify('##???#####?#?#')),
            ]));

            $materials = ['Cement (bags)', 'Steel Rods (tons)', 'Bricks (units)', 'Sand (cu.ft)', 'Paint (litres)', 'Tiles (boxes)', 'Wiring (rolls)', 'Pipes (units)'];
            foreach (range(1, 12) as $n) {
                $status = $faker->randomElement(['draft', 'pending', 'approved', 'approved', 'rejected']);
                $order = PurchaseOrder::create([
                    'vendor_id' => $vendors->random()->id,
                    'status' => $status,
                    'payment_method' => $faker->randomElement(['cash', 'cheque', 'upi', 'bank_transfer']),
                    'approved_by' => in_array($status, ['approved', 'rejected']) ? $faker->randomElement($userIds) : null,
                    'total_amount' => 0,
                ]);

                $total = 0;
                foreach (range(1, rand(2, 5)) as $line) {
                    $qty = rand(10, 200);
                    $unit = rand(50, 2000);
                    $gst = $faker->randomElement([5, 12, 18, 28]);
                    $lineTotal = $qty * $unit * (1 + $gst / 100);
                    PurchaseOrderItem::create([
                        'purchase_order_id' => $order->id,
                        'item_name' => $faker->randomElement($materials),
                        'quantity' => $qty,
                        'unit_price' => $unit,
                        'gst' => $gst,
                        'total' => $lineTotal,
                    ]);
                    $total += $lineTotal;
                }
                $order->update(['total_amount' => $total]);
            }

            $this->command?->info('Seeding leads and site visits...');
            foreach (range(1, 20) as $n) {
                $lead = Lead::create([
                    'customer_id' => $faker->boolean(80) ? $customers->random()->id : null,
                    'source' => $faker->randomElement(['Website', 'Referral', 'Walk-in', 'Property Portal', 'Social Media']),
                    'status' => $faker->randomElement(['new', 'contacted', 'visited', 'interested', 'lost']),
                    'assigned_to' => $faker->randomElement($userIds),
                ]);

                foreach (range(0, rand(0, 2)) as $v) {
                    if ($v === 0 && ! $faker->boolean(70)) {
                        continue;
                    }
                    SiteVisit::create([
                        'lead_id' => $lead->id,
                        'visit_date' => Carbon::now()->subDays(rand(1, 60))->setTime(rand(9, 18), 0),
                        'feedback' => $faker->sentence(),
                    ]);
                }
            }

            $this->command?->info('Seeding bookings, installments and payments...');
            $bookableFlats = $availableFlats->shuffle()->take(10);
            foreach ($bookableFlats as $flat) {
                $flat->update(['status' => $faker->randomElement(['booked', 'sold'])]);
                $booking = Booking::create([
                    'customer_id' => $customers->random()->id,
                    'flat_id' => $flat->id,
                    'booking_date' => Carbon::now()->subDays(rand(5, 120)),
                    'token_amount' => $faker->numberBetween(1, 5) * 50000,
                    'status' => $faker->randomElement(['confirmed', 'in_progress', 'completed']),
                ]);

                $installmentCount = rand(3, 6);
                $perInstallment = round($flat->price / $installmentCount, 2);
                for ($i = 0; $i < $installmentCount; $i++) {
                    $dueDate = Carbon::now()->subMonths($installmentCount - $i);
                    $isPaid = $faker->boolean(55);
                    $installment = Installment::create([
                        'booking_id' => $booking->id,
                        'amount' => $perInstallment,
                        'due_date' => $dueDate,
                        'status' => $isPaid ? 'paid' : ($dueDate->isPast() ? 'overdue' : 'pending'),
                    ]);

                    if ($isPaid) {
                        Payment::create([
                            'installment_id' => $installment->id,
                            'amount' => $perInstallment,
                            'method' => $faker->randomElement(['cash', 'cheque', 'upi', 'bank_transfer']),
                            'transaction_ref' => strtoupper($faker->bothify('TXN########')),
                            'paid_at' => (clone $dueDate)->addDays(rand(0, 10)),
                        ]);
                    }
                }
            }

            $this->command?->info('Seeding contractors, assignments, attendance and payments...');
            $specializations = ['Civil Work', 'Plumbing', 'Electrical', 'Carpentry', 'Painting', 'Masonry', 'Tiling', 'Welding'];
            $contractors = collect(range(1, 8))->map(fn () => Contractor::create([
                'name' => $faker->name(),
                'specialization' => $faker->randomElement($specializations),
                'phone' => $faker->numerify('+91 9#########'),
            ]));

            foreach ($contractors as $contractor) {
                // Assignments
                foreach (range(1, rand(1, 3)) as $a) {
                    ContractorTask::create([
                        'contractor_id' => $contractor->id,
                        'task_id' => $allTasks->random()->id,
                        'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                        'progress' => rand(0, 100),
                    ]);
                }

                // Attendance for the last 7 days
                foreach (range(0, 6) as $d) {
                    Attendance::create([
                        'contractor_id' => $contractor->id,
                        'date' => Carbon::now()->subDays($d)->toDateString(),
                        'status' => $faker->randomElement(['present', 'present', 'present', 'absent']),
                    ]);
                }

                // Payments
                foreach (range(1, rand(1, 3)) as $p) {
                    ContractorPayment::create([
                        'contractor_id' => $contractor->id,
                        'amount' => $faker->numberBetween(10, 150) * 1000,
                        'date' => Carbon::now()->subDays(rand(1, 90)),
                        'status' => $faker->randomElement(['pending', 'paid']),
                    ]);
                }
            }

            $this->command?->info('Seeding settings...');
            $settings = [
                'company_name' => 'REMS Realtors Pvt. Ltd.',
                'currency' => 'INR',
                'support_email' => 'support@rems.test',
                'office_address' => $faker->address(),
                'financial_year' => date('Y') . '-' . (date('y') + 1),
            ];
            foreach ($settings as $key => $value) {
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        });

        $this->command?->info('Mock data seeding complete.');
    }
}
