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
						<div class="s_t_parts">
							Запчасти
						</div>
						<div class="s_t_services">
							Услуги
						</div>
					</div>

					<p>
						Отправьте запрос, на который ответят специалисты
						профильных организаций
					</p>

				</div>

			</div>

			<div class="clear-fix"></div>

		</div>

	</div>

@stop