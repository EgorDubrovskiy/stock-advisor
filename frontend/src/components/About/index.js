import React from 'react';
import './index.scss';

//This component has information that describe this project
export default function About() {
  return (
    <div className="container pt-3">
      <div className="pb-4">
        <div className="title-font-large text-center">
           О проекте
        </div>
        <p className="sub-title-font text-center">
          Проект представляет из себя приложение для управление и отслеживания финансовой информации относительно компаний: к примеру цены на акции, когда и на каких площадках идет торговля акциями различных компаний. В проекте предоставлена возможно получить информацию о 10-и самых популярных компаний, список всех компаний, можно добавить компании в своего рода закладки после авторизации чтобы в любое время получить к ним быстрый доступ. Информация о компаниях ежедневно обновлятется и все хранится в базе данных.
        </p>
      </div>
    </div>
  );
}
