<?php


namespace App\Http\Livewire\Order;


use App\Entityes\Car;
use App\Entityes\Delivery;
use App\Entityes\DeliveryProducts;
use App\Entityes\Order;
use App\Helpers\AppHelpers;
use App\Http\Livewire\Carrier;
use App\Mail\Base;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Image;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryTable extends Component
{

    use WithPagination;

    public $ttn;
    public $status_delivery_comment;
    public $status_payment_comment;

    public $sortColumn = 'id';
    public $sortDirection = 'desc';
    public $perPage = 25;

    public $searchAddress = null;
    public $searchDriverSurnName = null;
    public $searchPaymentStatus = null;
    public $searchDateBefore;
    public $searchDateAfter;
    public $searchCarrierId;

    public $deliveryId;
    public $order;

    public $imagePath;
    public $proxyViewMode = false;

    public function mount($id = null)
    {
        if($id) {
            $this->order = Order::where('id', $id)->with('products')->first();
        }
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }

    public function setId($id)
    {
        $this->deliveryId = $id;
    }

    public function setStatus($id, $status)
    {
        if(!$delivery = Delivery::find($id)) {
            return;
        }

        $text = 'Статус: ';

        if($status != $delivery->current_status + 1) {
            $this->dispatchBrowserEvent('add_notify', ['type' => 'danger', 'text' => 'Этот статус не может быть назначен.', 'title' => 'Доставка №' . $delivery->id]);
            $this->dispatchBrowserEvent('close_modal');
            $this->emit('refresh');
            return;
        }

        if($status == Delivery::STATUS_DELIVERY) {
            $delivery->current_status = Delivery::STATUS_DELIVERY;
            $text .= 'отгружена.';
        }

        if($status == Delivery::STATUS_COMPLETE) {
            $delivery->current_status = Delivery::STATUS_COMPLETE;
            $text .= 'доставлена. <br>Номер ТТН добавлен.';
        }

        if($status == Delivery::STATUS_PAYMENT) {
            $delivery->current_status = Delivery::STATUS_PAYMENT;
            $text .= 'оплачена водителю.';
        }

        $delivery->saveOrFail();
        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => $text, 'title' => 'Доставка №' . $delivery->id]);
        $this->dispatchBrowserEvent('close_modal');
        $this->emit('refresh');
    }

    public function setProxy($id)
    {
        if(!$delivery = Delivery::find($id)) {
            return;
        }

        $this->deliveryId = $delivery->id;

        if($delivery->current_status < Delivery::STATUS_DRIVER || $delivery->send_proxy != 0) {
            $this->dispatchBrowserEvent('add_notify', ['type' => 'danger', 'text' => 'Доверенность не может быть отправлена.', 'title' => 'Доставка №' . $delivery->id]);
            $this->dispatchBrowserEvent('close_modal');
            $this->emit('refresh');
            return;
        }

        if(!$delivery->carrier->is_default) {
            $this->dispatchBrowserEvent('add_notify', ['type' => 'danger', 'text' => 'Доверенность не может быть отправлена. Чужой перевозчик', 'title' => 'Доставка №' . $delivery->id]);
            return;
        }

        if($delivery->carrier_id == 1) {
            $image = \Intervention\Image\Facades\Image::make(storage_path('proxy_semenov.jpg'));
        } else {
            $image = \Intervention\Image\Facades\Image::make(storage_path('proxy_unikom.jpg'));
        }

        $fontPath = public_path('fonts/RF_Dewi_Bold.ttf');

        $image->text($delivery->id, 265, 325, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text(now()->format('d.m.Y'), 470, 325, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text(now()->addDay(10)->format('d.m.Y'), 750, 325, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text($delivery->driver->surname . ' ' . $delivery->driver->name . ' ' . $delivery->driver->middle_name, 1025, 325, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text($delivery->id, 1085, 1070, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(45);
            //$font->color('#3d3d3d');
            //$font->align('right');
           // $font->valign('bottom');
            //$font->angle(180);
        });

        $image->text(now()->format('d.m.Y'), 710, 1153, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text(now()->addDay(10)->format('d.m.Y'), 710, 1200, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(30);
        });

        $image->text($delivery->driver->surname . ' ' . $delivery->driver->name . ' ' . $delivery->driver->middle_name, 1340, 1700, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(32);
        });

        $passport_series = substr($delivery->driver->passport_series_and_number, 0, 4);
        $passport_number = substr($delivery->driver->passport_series_and_number, 4, 10);

        $image->text($passport_series, 635, 1780, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(32);
        });

        $image->text($passport_number, 1085, 1780, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(32);
        });

        $image->text($delivery->driver->passport_issued_by, 635, 1825, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(32);
        });

        $image->text($delivery->driver->passport_date_of_issue->format('d.m.Y'), 635, 1870, function($font) {
            $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
            $font->size(32);
        });

        $y = '2442';

        foreach ($delivery->products as $product) {
            $image->text($product->product->title, 310, $y, function($font) {
                $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
                $font->size(30);
            });

            $image->text($product->product_count . ' ' . AppHelpers::num2tn($product->product_count), 1600, $y, function($font) {
                $font->file(public_path('fonts/RF_Dewi_Bold.ttf'));
                $font->size(30);
            });

            $y += 50;
        }

        $path = 'proxies/'.random_int(1, 10000) . '.jpg';

        $image->save(storage_path('app/public/' . $path));

        $delivery->proxy_path = $path;
        $delivery->saveOrFail();

        $this->imagePath = '/storage/' . $path;
        $this->dispatchBrowserEvent('open_proxy_modal');
    }

    public function resetProxy()
    {
        $this->imagePath = null;
        $this->deliveryId = null;
        $this->proxyViewMode = false;
    }

    public function getProxy($id)
    {
        if(!$delivery = Delivery::find($id)) {
            return;
        }

        $this->proxyViewMode = true;
        $this->imagePath = '/storage/' . $delivery->proxy_path;
        $this->deliveryId = $delivery->id;
    }

    public function sendProxy($id)
    {
        if(!$delivery = Delivery::find($id)) {
            return;
        }

        Mail::to('proger.gost@gmail.com')->send(new Base($delivery->proxy_path, $delivery->driver->surname . ' ' . $delivery->driver->name . ' ' . $delivery->driver->middle_name));

        $delivery->send_proxy = 1;
        $delivery->saveOrFail();
        $this->dispatchBrowserEvent('close_modal');
        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Доверенность отправлена.', 'title' => 'Доставка №' . $delivery->id]);
    }

    public function setTtn()
    {
        if(!$delivery = Delivery::find($this->deliveryId)) {
            return;
        }

        $validatedDate = $this->validate([
            'ttn' => 'required|integer',
        ]);

        $delivery->ttn_number = $this->ttn;
        $delivery->saveOrFail();
        $this->setStatus($delivery->id, Delivery::STATUS_COMPLETE);
    }

    public function setStatusDeliveryComment()
    {
        if(!$delivery = Delivery::find($this->deliveryId)) {
            return;
        }

        $validatedDate = $this->validate([
            'status_delivery_comment' => 'nullable|integer',
        ]);

        $delivery->status_delivery_comment = $this->status_delivery_comment;
        $delivery->saveOrFail();
        $this->setStatus($delivery->id, Delivery::STATUS_DELIVERY);
    }

    public function delete()
    {
        if(!$this->deliveryId) {
            return;
        }

        $delivery = Delivery::find($this->deliveryId)->delete();

        $this->deliveryId = null;
        $this->dispatchBrowserEvent('close_modal');
        $this->emit('refresh');

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Запись удалена.', 'title' => 'Доставка №' . $delivery->id]);
    }

    public function setPayment($id)
    {
        $delivery = Delivery::find($id);

        $delivery->payment_status = 1;

        $delivery->saveOrFail();

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Статус: оплата от завода получена.', 'title' => 'Доставка №' . $delivery->id]);
        $this->emit('refresh');
    }

    public function render()
    {
        if($this->order) {
            $text = '<p>Товары в заказе на которые нет доставок:</p>';

            $deliveriesId = [];

            foreach ($this->order->deliveries as $delivery) {
                $deliveriesId[] = $delivery->id;
            }

            foreach ($this->order->products as $product) {

                $deliveryProduct = DeliveryProducts::whereIn('delivery_id', $deliveriesId)->where('product_id', $product->product_id)->get();

                if($deliveryProduct->count() < 1) {
                    $text .= '- ' . $product->product->title .': <span class="font-weight-black">' . $product->count . 'тн.</span><br>';
                } else {
                    $dpCnt = 0;
                    foreach ($deliveryProduct as $item) {
                        $dpCnt += $item->product_count;
                    }
                    if($product->count - $dpCnt != 0) {
                        $text .= '- ' . $product->product->title .': <span class="font-weight-black">' . ($product->count - $dpCnt) . 'тн.</span><br>';
                    }
                }
            }

            $pageTitle = 'Доставки по заказу №' . $this->order->id . ' для ' . $this->order->customer->title;

            $deliveries = Delivery::select('*')->where('order_id', $this->order->id)
                ->selectRaw('(SELECT SUM(client_price * delivery_products.product_count) FROM delivery_products WHERE delivery_id = deliveries.id) AS sum_client_price')
                ->selectRaw('(SELECT sum_client_price - driver_price) AS profit')
                ->with('carrier')->with('products')->with('driver')->with('car')
                ->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        } else {
            $text = null;

            $pageTitle = 'Доставки';

            $deliveries = Delivery::select('*')
                ->selectRaw('(SELECT SUM(client_price * delivery_products.product_count) FROM delivery_products WHERE delivery_id = deliveries.id) AS sum_client_price')
                ->selectRaw('(SELECT sum_client_price - driver_price) AS profit')
                ->with('carrier')->with('products')->with('driver')->with('car');

            if(!is_null($this->searchAddress) && $this->searchAddress != '') {
                $deliveries = $deliveries->where('city', 'LIKE', '%' . $this->searchAddress . '%' );
            }

            if(!is_null($this->searchCarrierId) && $this->searchCarrierId != '') {
                $deliveries = $deliveries->where('carrier_id', $this->searchCarrierId );
            }

            if(!is_null($this->searchDriverSurnName) && $this->searchDriverSurnName != '') {
                $deliveries = $deliveries->whereHas('driver', function ($query) {
                    $query->where('surname', 'LIKE', '%' . $this->searchDriverSurnName . '%' );
                });
            }

            if(!is_null($this->searchPaymentStatus) && $this->searchPaymentStatus != '') {
                $deliveries = $deliveries->where('payment_status', $this->searchPaymentStatus);
            }

            if($this->searchDateBefore) {
                $deliveries = $deliveries->where('desired_date', '>=', $this->searchDateBefore);
            }

            if($this->searchDateAfter) {
                $deliveries = $deliveries->where('desired_date', '<=', $this->searchDateAfter);
            }

            $deliveries = $deliveries->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        }


        return view('livewire.order.delivery_table', [
            'pageTitle' => $pageTitle,
            'text' => $text,
            'carriers' => \App\Entityes\Carrier::all(),
            'deliveries' => $deliveries
        ])->extends('layout');
    }

}