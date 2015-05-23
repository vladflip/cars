@extends('layouts.main')

@section('body')

	<div class="main-content">

		<div class="wide-image"></div>
		
		<div class="container">
			
			<div class="m_left">
				
				<div class="m_catalog">
					
					<h3>Каталог Организаций</h3>

					<ul class="m_menu">
						
						<li>Магазины запчастей</li>
						<li>Разборки (б/у)</li>
						<li>Тех. центры</li>
						<li>Автосервисы</li>
						<li>Мойки грузовые</li>
						<li>Установка оборудования</li>
						<li>Шины и диски</li>

					</ul>

					<div class="m_add-org">
						Добавить организацию
					</div>

				</div>

			</div>

			<div class="m_middle">
				
				<h3>Поиск организации</h3>

				<div class="m_type">
					
					<div class="m_t_header">
						<div class="row-image"></div>
						<h3>Выберите тип</h3>
						<hr>
					</div>

					<ul>
						<li>
							<div></div>
							<span>Грузовики</span>
						</li>
						<li>
							<div></div>
							<span>Автобусы</span>
						</li>
						<li>
							<div></div>
							<span>Малый коммерческий транспорт</span>
						</li>
						<li>
							<div></div>
							<span>Прицепы</span>
						</li>
					</ul>

				</div>

				<div class="parts-block">
					<div class="p-b_header">
						<div class="row-image"></div>
						<h3>Рубрики</h3>
						<hr>
					</div>
					
					<ul class="p-b_categories">
						<li><span>Магазины запчастей</span></li>
						<li><span class="active">Разборки (б/у)</span></li>
						<li><span class="active">Технические центры</span></li>
						<li><span>Автосервисы</span></li>
						<li><span>Мойки грузовые</span></li>
						<li><span>Установка оборудования</span></li>
						<li><span class="active">Шины и диски</span></li>
					</ul>
				</div>

				<div class="m_makes">
					
					<div class="m_m_header">
						<div class="row-image"></div>
						<h3>Выберите производителя</h3>
						<hr>
					</div>

					<ul>
						<li><span>Lexus</span></li>
						<li><span>Honda</span></li>
						<li><span class="active">Jeep</span></li>
						<li><span>Audi</span></li>
						<li><span>Jaguar</span></li>
						<li><span>Daewoo</span></li>
						<li><span>Porsche</span></li>
						<li><span>Ford</span></li>
						<li><span>Bentley</span></li>
						<li><span>Subaru</span></li>
						<li><span>Chevrolet</span></li>
						<li><span>Dodge</span></li>
						<li><span>Lexus</span></li>
						<li><span>Honda</span></li>
						<li><span>Jeep</span></li>
						<li><span>Audi</span></li>
						<li><span>Jaguar</span></li>
						<li><span>Daewoo</span></li>
						<li><span>Porsche</span></li>
						<li><span>Ford</span></li>
						<li><span>Bentley</span></li>
						<li><span>Subaru</span></li>
						<li><span>Chevrolet</span></li>
						<li><span>Dodge</span></li>
					</ul>

					<div class="m_show-orgs">
						Показать
					</div>

				</div>

			</div>

			<div class="m_right">
				
				<div class="search-side-bar">
					
					<h3>Найти</h3>

					<div class="s-s_toogler">
						<div class="s_t_parts active">
							Запчасти
						</div>
						<div class="s_t_services">
							Услуги
						</div>
					</div>

					<h4>Тип</h4>
					<select name="" id="">
						<option value="">Грузовики</option>
						<option value="">Автобусы</option>
						<option value="">Малый коммерческий транспорт</option>
						<option value="">Прицепы</option>
					</select>

					<h4>Производитель</h4>
					<select name="" id="">
						<option value="">Audi</option>
					</select>

					<h4>Модель</h4>
					<select name="" id="">
						<option value="">TT</option>
					</select>

					<h4>Год выпуска</h4>
					<input type="text">

					<input type="checkbox"> <label for="">Новая</label>
					<input type="checkbox"> <label for="">б/у</label>

					<h4>Дополнительно</h4>
					<input type="text" class="s-s_more" value="VIN и т.п">

					<div class="s-s_send">Отправить запрос</div>

				</div>

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop